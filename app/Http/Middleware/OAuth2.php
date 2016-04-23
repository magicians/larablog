<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\UserRepository;
use Closure;
use Illuminate\Auth\Guard;
use League\OAuth2\Server\Exception\InvalidScopeException;
use League\OAuth2\Server\ResourceServer;
use LucaDegasperi\OAuth2Server\Authorizer;
use LucaDegasperi\OAuth2Server\Storage\FluentClient;

class OAuth2
{

    protected $authorizer;
    protected $userRepository;
    protected $auth;
    protected $fluentClient;
    protected $resourceServer;

    /**
     * ResolveAuthenticatedUser constructor.
     * @param Authorizer $authorizer
     * @param Guard $auth
     * @param UserRepository $userRepository
     * @param FluentClient $fluentClient
     * @param ResourceServer $resourceServer
     * @param bool $httpHeadersOnly
     */
    public function __construct(
        Authorizer $authorizer,
        Guard $auth,
        UserRepository $userRepository,
        FluentClient $fluentClient,
        ResourceServer $resourceServer,
        $httpHeadersOnly = false
    )
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
        $this->userRepository = $userRepository;
        $this->auth = $auth;
        $this->fluentClient = $fluentClient;
        $this->resourceServer = $resourceServer;
    }


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopesString
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopesString = null)
    {
        $scopes = [];

        if (!is_null($scopesString)) {
            $scopes = explode('+', $scopesString);
        }

        $this->authorizer->setRequest($request);

        $this->authorizer->validateAccessToken($this->httpHeadersOnly);
        $this->validateScopes($scopes);

        $token = $this->authorizer->getAccessToken();

        if(!$token){
            return $next($request);
        }

        $session = $token->getSession();

        $id = $session->getOwnerId();

        $this->auth->loginUsingId($id);

        return $next($request);
    }

    /**
     * Validate the scopes.
     *
     * @param $scopes
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes($scopes)
    {
        if (!empty($scopes) && !$this->authorizer->hasScope($scopes)) {
            throw new InvalidScopeException(implode(',', $scopes));
        }
    }
}

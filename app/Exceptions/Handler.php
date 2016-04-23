<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Exception\InvalidRequestException;
use League\OAuth2\Server\Exception\OAuthException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        else if($e instanceof AccessDeniedException || $e instanceof InvalidRequestException){
            $e = new UnauthorizedHttpException(null, $e->getMessage(), $e);
        }
        else if($e instanceof OAuthException){
            $e = new HttpException(
                $e->httpStatusCode,
                $e->getMessage(),
                $e->getPrevious(),
                $e->getHttpHeaders(),
                $e->getCode()
            );
        }

        //If request wants json we send an Json Exception
        if($this->shouldRenderJson($request)){
            return $this->renderJson($e);
        }

        return parent::render($request, $e);
    }

    /**
     * Logic to check if we should render a json exception
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldRenderJson($request)
    {
        // if request wants json
        if($request->wantsJson()){
            return true;
        }

        return false;
    }

    protected function renderJson(Exception $e)
    {
        $statusCode = $this->getStatusCode($e);

        if (! $message = $e->getMessage()) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $responseData = [
            'message' => $message,
            'status_code' => $statusCode
        ];

        if ($e instanceof ResourceException && $e->hasErrors()) {
            $responseData['errors'] = $e->getErrors();
        }

        if ($code = $e->getCode()) {
            $responseData['code'] = $code;
        }

        if ($this->runningInDebugMode()) {
            $responseData['debug'] = [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'class' => get_class($e),
                'trace' => explode("\n", $e->getTraceAsString())
            ];
        }

        return new Response($responseData, $this->getStatusCode($e), $this->getHeaders($e));
    }

    /**
     * Get the exception status code.
     *
     * @param \Exception $e
     * @param int        $defaultStatusCode
     * @return int
     */
    protected function getStatusCode(Exception $e, $defaultStatusCode = 500)
    {
        return ($e instanceof HttpExceptionInterface) ? $e->getStatusCode() : $defaultStatusCode;
    }

    /**
     * Get the headers from the exception.
     *
     * @param \Exception $e
     * @return array
     */
    protected function getHeaders(Exception $e)
    {
        return $e instanceof HttpExceptionInterface ? $e->getHeaders() : [];
    }

    /**
     * Determines if we are running in debug mode.
     *
     * @return bool
     */
    protected function runningInDebugMode()
    {
        return config('app.debug');
    }
}

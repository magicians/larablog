<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Cors
{

    protected $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers' => 'Authorization, Origin, x-requested-with, Content-Type',
        'Access-Control-Expose-Headers' => 'Authorization'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = ($request->getMethod() === "OPTIONS") ? new Response() : $next($request);

        return $this->addHeaders($response);
    }

    protected function addHeaders($response)
    {
        foreach($this->headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}

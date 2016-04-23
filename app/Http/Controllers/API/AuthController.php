<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use LucaDegasperi\OAuth2Server\Authorizer;

class AuthController extends Controller
{

    /**
     * @param Authorizer $authorizer
     * @return array
     */
    public function getAccessToken(Authorizer $authorizer)
    {
        return $authorizer->issueAccessToken();
    }

}

<?php /** @var Router $router */

use Illuminate\Routing\Router;

$router->get('/', function () {
    return view('welcome');
});

$router->group([
    'namespace' => 'App\Http\Controllers\API',
    'prefix' => '/api',
    'middleware' => ['cors']
], function(Router $api){

    $api->post('/oauth2/access_token', 'AuthController@getAccessToken');

    $api->post('/password/request', 'PasswordResetController@requestReset');
    $api->post('/password/reset', 'PasswordResetController@doReset');

    // Routes that requires user to be authenticated
    $api->group(['middleware' => ['oauth', 'oauth-user']], function (Router $api) {

        $api->get('/profile/me', 'ProfileController@getUser');
        $api->put('/profile/password', 'ProfileController@updatePassword');
        $api->put('/profile', 'ProfileController@updateUser');

        $api->resource('/post', 'PostController');

    });
});

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiControllerHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    use ApiControllerHelpers;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * ProfileController constructor.
     * @param $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        $user = $this->auth->user();

        return $this->respondJson($user);
    }

    /**
     * @param Request $request
     * @param Connection $db
     * @return int
     * @throws \Exception
     * @throws \Throwable
     */
    public function updateUser(Request $request, Connection $db)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        /**
         * @var User $user
         */
        $user = $this->auth->user();

        $user->fill($request->all());

        return $this->respondJson($user->save());
    }

    /**
     * @param Request $request
     * @return int
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|max:32|confirmed'
        ]);

        $user = $this->auth->user();
        $user->password = bcrypt($request->get('password'));

        return $this->respondJson($user->save());
    }
    
}

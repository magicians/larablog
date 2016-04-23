<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PasswordResetController extends Controller
{

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function requestReset(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        if ($response !== Password::RESET_LINK_SENT) {
            throw new UnprocessableEntityHttpException(trans($response));
        }

        return response()->json([
            'success' => true,
            'message' => trans($response)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if($response !== Password::PASSWORD_RESET){
            throw new UnprocessableEntityHttpException(trans($response));
        }

        return response()->json([
            'success' => true,
            'message' => trans($response)
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param User $user
     * @param  string $password
     * @return User
     */
    protected function resetPassword(User $user, $password)
    {
        $user->password = $password;
        $user->save();

        return $user;
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return 'Recuperação de Senha';
    }
}
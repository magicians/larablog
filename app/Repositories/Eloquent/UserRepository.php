<?php namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository as UserRepositoryContract;

class UserRepository extends BaseRepository implements UserRepositoryContract
{

    protected $modelClass = User::class;

    /**
     * Get a user by its login username
     *
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUsername($username)
    {
        return $this->newQuery()
            ->where(User::LOGIN_USERNAME, $username)
            ->first();
    }

    /**
     * Retrieve an user by its email verification token
     *
     * @param string $token
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByVerficationToken($token)
    {
        return $this->newQuery()
            ->where('verification_token', $token)
            ->first();
    }

}
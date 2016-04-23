<?php namespace App\Repositories\Contracts;

interface UserRepository extends BaseRepository
{

    /**
     * Get a user by its login username
     *
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUsername($username);



    /**
     * Retrieve an user by its email verification token
     *
     * @param string $token
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByVerficationToken($token);

}
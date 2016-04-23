<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\RoleRepository as RoleRepositoryContract;
use Artesaos\Defender\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryContract
{
    protected $modelClass = Role::class;

    /**
     * Create a role given a name
     *
     * @param $name
     * @param $readableName
     * @return mixed
     */
    public function createRole($name, $readableName)
    {
        return $this->create(['name' => $name, 'readable_name' => $readableName]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findRole($name)
    {
        $result = $this->newQuery()->where('name', $name)->first();

        return $result;
    }
}
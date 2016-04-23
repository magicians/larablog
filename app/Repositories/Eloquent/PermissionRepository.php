<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;
use Artesaos\Defender\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryContract
{
    protected $modelClass = Permission::class;

    /**
     * Find a permission by its name
     *
     * @param $name
     * @return mixed
     */
    public function findPermission($name)
    {
        $result = $this->newQuery()->where('name', $name)->first();

        return $result;
    }

    /**
     * Create a permission given a name and a display name
     *
     * @param $name
     * @param $niceName
     * @return mixed
     */
    public function createPermission($name, $niceName)
    {
        return $this->create([
            'name' => $name,
            'readable_name' => $niceName
        ]);
    }
}
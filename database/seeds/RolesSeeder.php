<?php

use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    protected $roleRepo;
    protected $permissionRepo;

    /**
     * RolesSeeder constructor.
     * @param $roleRepo
     * @param $permissionRepo
     */
    public function __construct(RoleRepository $roleRepo, PermissionRepository $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRole('author', 'Author', [
            'resource:post',
            'profile.show',
            'profile.update'
        ]);

        $this->createRole('editor', 'Editor', [
            'resource:post',
            'resource:tag',
            'resource:category',
            'profile.show',
            'profile.update'
        ]);

        $this->createRole('admin', 'Administrator', [
            'resource:nota',
            'resource:comment',
            'resource:empresa',
            'resource:contador',
            'profile.show',
            'profile.update'
        ]);
    }

    /**
     * Create a role given its name and a array of permissions
     *
     * @param $roleName
     * @param $readableName
     * @param array $permissionsNames
     */
    protected function createRole($roleName, $readableName, array $permissionsNames)
    {
        //Create the role
        $role = $this->roleRepo->createRole($roleName, $readableName);

        $permissionsNames = $this->expandResourcePermissions($permissionsNames);

        //attach permissions to role
        foreach ($permissionsNames as $permissionName) {
            $permission = $this->permissionRepo->findPermission($permissionName);

            if(!$permission){
                continue;
            }

            $role->attachPermission($permission);
        }
    }

    /**
     * @param array $permissionsNames
     * @return array
     */
    protected function expandResourcePermissions(array $permissionsNames)
    {
        $newPermissionsNames = [];

        foreach ($permissionsNames as $permissionName) {

            if (strpos($permissionName, 'resource:') > -1) {
                $permissionResourceBase = str_replace('resource:', '', $permissionName);

                foreach (['index', 'show', 'store', 'update', 'destroy'] as $permissionAction){
                    $newPermissionsNames[] = $permissionResourceBase . '.' . $permissionAction;
                }

                continue;
            }

            $newPermissionsNames[] = $permissionName;

        }

        return $newPermissionsNames;
    }
}

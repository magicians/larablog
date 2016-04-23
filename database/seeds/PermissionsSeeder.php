<?php

use App\Repositories\Eloquent\PermissionRepository;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Define you permissions here
     *
     * @var array
     */
    protected $permissions = [
        'resource:post' => 'post',
        'resource:comment' => 'comment',
        'resource:tag' => 'tag',
        'resource:category' => 'category',
        'profile.show' => 'Ver perfil',
        'profile.update' => 'Editar perfil'
    ];

    protected $permissionRepo;

    /**
     * PermissionsSeeder constructor.
     * @param $permissionRepo
     */
    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }


    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        foreach ($this->permissions as $key => $value) {

            if (strpos($key, 'resource:') > -1) {
                $key = str_replace('resource:', '', $key);
                $this->createResourcePermissions($key, $value);
                continue;
            }

            $this->createSinglePermission($key, $value);

        }

    }

    /**
     * Create a single permission
     *
     * @param $name
     * @param $readableName
     */
    protected function createSinglePermission($name, $readableName)
    {
        $this->permissionRepo->createPermission($name, $readableName);
    }

    /**
     * Create several permissions
     *
     * @param $resourceName
     * @param $resourcereadableName
     */
    protected function createResourcePermissions($resourceName, $resourcereadableName)
    {
        $permissons = $this->getPermissionResourceActions($resourceName, $resourcereadableName);

        foreach ($permissons as $action => $readableName) {
            $this->createSinglePermission($action, $readableName);
        }
    }

    /**
     * @param $resourceName
     * @param $resourcereadableName
     * @return array
     */
    protected function getPermissionResourceActions($resourceName, $resourcereadableName)
    {
        return [
            $resourceName . '.index' => 'Listar ' . $resourcereadableName,
            $resourceName . '.show' => 'Ver ' . $resourcereadableName,
            $resourceName . '.store' => 'Criar ' . $resourcereadableName,
            $resourceName . '.update' => 'Editar ' . $resourcereadableName,
            $resourceName . '.destroy' => 'Excluir ' . $resourcereadableName
        ];
    }
}

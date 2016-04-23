<?php

use App\Models\User;
use App\Models\Usuario;
use App\Repositories\Contracts\RoleRepository;
use Illuminate\Database\Seeder;
use LucaDegasperi\OAuth2Server\Storage\FluentClient;

class OAuth2Seeder extends Seeder
{
    protected $authClient;

    /**
     * OAuth2Seeder constructor.
     * @param $authClient
     */
    public function __construct(FluentClient $authClient)
    {
        $this->authClient = $authClient;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'email' => 'admin@larablog.com',
            'password' => '12345678',
            'verified' => true
        ]);
        $role = app()->make(RoleRepository::class)->findRole('admin');
        $admin->attachRole($role);

        // Clients
        $this->authClient->create("AdminPanel", "1", "1");
        
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(OAuth2Seeder::class);

        Model::reguard();
    }
}

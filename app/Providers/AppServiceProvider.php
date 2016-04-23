<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\UserRepository as UserRepositoryContract;
use App\Repositories\Contracts\PostRepository as PostRepositoryContract;
use App\Repositories\Contracts\RoleRepository as RoleRepositoryContract;
use App\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;

use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\PostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryContract::class, PermissionRepository::class);
    }
}

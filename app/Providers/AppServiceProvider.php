<?php

namespace App\Providers;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\UserInterface;
use App\Http\Repositories\AuthRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

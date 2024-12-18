<?php

namespace App\Modules\Preorder;

use Illuminate\Support\ServiceProvider;

class PreorderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register module services and bindings
    }

    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        // $this->loadViewsFrom(__DIR__ . '/Views', 'preorder');
        // $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}

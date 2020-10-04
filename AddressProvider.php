<?php


namespace NRB\Address;


use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class AddressProvider extends ServiceProvider
{

    /**
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ .'/addresses.php' => config_path('addresses.php')
            ], 'config');

            $this->publishes([
                __DIR__ . 'Migrations/2020_05_20_012233_create_addresses_table.php' => database_path('/migrations/2020_05_20_012233_create_addresses_table'),
            ], 'migrations');
        }

        $this->loadMigrationsFrom( __DIR__ . '/Migrations/');

    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ .'/addresses.php',
            'addresses'
        );
    }
}

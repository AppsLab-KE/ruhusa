<?php


namespace AppsLab\Acl;

use Appslab\Acl\Commands\CreatePermission;
use Appslab\Acl\Commands\CreateRole;
use Appslab\Acl\Commands\InstallPackage;
use AppsLab\Acl\Middleware\PermissionMiddleware;
use AppsLab\Acl\Middleware\RoleMiddleware;
use AppsLab\Acl\Middleware\RuhusaMiddleware;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RuhusaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['router']->aliasMiddleware('roles', RoleMiddleware::class);
        $this->app['router']->aliasMiddleware('permissions', PermissionMiddleware::class);

        if ($this->app->runningInConsole()){
            $this->registerPublishing();
        }
        $this->registerResources();
        $this->registerBladeExtensions();
        $this->authorize();
    }

    public function register()
    {
        $this->loadCommands();
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');
    }

    private function registerBladeExtensions()
    {
        Blade::directive('role', function ($role){
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });

        Blade::directive('elserole', function ($role){
            return "<?php else if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });

        Blade::directive('endrole', function (){
            return "<?php endif; ?>";
        });
    }

    private function registerPublishing()
    {
        //this is to allow you to modify the tables according to your project need

        $this->publishes([
            __DIR__.'/../databases/migrations/2018_10_12_000000_create_permissions_table.php' =>
            'databases/migrations/2018_10_12_000000_create_permissions_table.php',
            __DIR__.'/../databases/migrations/2018_10_12_000000_create_roles_table.php' =>
            'databases/migrations/2018_10_12_000000_create_roles_table.php',
            __DIR__.'/../databases/migrations/2018_11_24_105604_create_users_permissions_table.php' =>
            'databases/migrations/2018_11_24_105604_create_users_permissions_table.php',
            __DIR__.'/../databases/migrations/2018_11_24_105604_create_users_roles_table.php' =>
             'databases/migrations/2018_11_24_105604_create_users_roles_table.php',
             __DIR__.'/../databases/migrations/2018_11_24_110643_create_roles_permissions_table.php' =>
             'databases/migrations/2018_11_24_110643_create_roles_permissions_table.php',
            __DIR__ . '/../config/ruhusa.php' => 'config/ruhusa.php'

        ], 'ruhusa');
    }

    protected function authorize()
    {
        if (config('ruhusa.models.permission') && Schema::hasTable(config('ruhusa.tables.permission'))){
            app(config('ruhusa.models.permission'))::get()->map(function ($permission){
                Gate::define($permission->slug, function ($user) use($permission){
                    return $user->hasPermissionTo($permission);
                });
            });
        }
    }

    protected function loadCommands()
    {
        if ($this->app->runningInConsole()){
            $this->commands([
//                InstallPackage::class,
//                CreateRole::class,
//                CreatePermission::class
            ]);
        }
    }
}

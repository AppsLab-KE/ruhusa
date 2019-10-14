<?php


namespace AppsLab\Acl;

use AppsLab\Acl\Commands\CreatePermission;
use AppsLab\Acl\Commands\CreateRole;
use AppsLab\Acl\Commands\InstallPackage;
use AppsLab\Acl\Middleware\PermissionMiddleware;
use AppsLab\Acl\Middleware\RoleMiddleware;
use AppsLab\Acl\Middleware\RuhusaMiddleware;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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
        $this->loadViews();
    }

    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ruhusa');
        $this->publishes([
            __DIR__.'/../resources/views/layouts/app.blade.php' => resource_path('views/vendor/ruhusa/layouts/app.blade.php'),
            __DIR__.'/../resources/views/acl/permission.blade.php' => resource_path('views/vendor/ruhusa/acl/permission.blade.php'),
            __DIR__.'/../resources/views/acl/role.blade.php' => resource_path('views/vendor/ruhusa/acl/role.blade.php'),
            __DIR__.'/../resources/views/acl/role-form-body.blade.php' => resource_path('views/vendor/ruhusa/acl/role-form-body.blade.php'),
            __DIR__.'/../resources/views/acl/permission-form-body.blade.php' => resource_path('views/vendor/ruhusa/acl/permission-form-body.blade.php'),
            __DIR__.'/../resources/views/acl/partials/_role-form.blade.php' => resource_path('views/vendor/ruhusa/acl/partials/_role-form.blade.php'),
            __DIR__.'/../resources/views/acl/partials/_permission-form.blade.php' => resource_path('views/vendor/ruhusa/acl/partials/_permission-form.blade.php'),
        ],'ruhusa-views');
    }

    public function register()
    {
        $this->loadCommands();
    }

    private function registerResources()
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function registerRoutes()
    {
        Route::group($this->routeConfig(), function (){
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfig()
    {
        return [
            'prefix' => config('ruhusa.route-prefix'),
            'middleware' => config('ruhusa.route-middleware')
        ];
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
            __DIR__.'/../database/migrations/2018_10_12_000000_create_permissions_table.php' =>
                'database/migrations/2018_10_12_000000_create_permissions_table.php',
            __DIR__.'/../database/migrations/2018_10_12_000000_create_roles_table.php' =>
                'database/migrations/2018_10_12_000000_create_roles_table.php',
            __DIR__.'/../database/migrations/2018_11_24_105604_create_users_permissions_table.php' =>
                'database/migrations/2018_11_24_105604_create_users_permissions_table.php',
            __DIR__.'/../database/migrations/2018_11_24_105604_create_users_roles_table.php' =>
                'database/migrations/2018_11_24_105604_create_users_roles_table.php',
            __DIR__.'/../database/migrations/2018_11_24_110643_create_roles_permissions_table.php' =>
                'database/migrations/2018_11_24_110643_create_roles_permissions_table.php',
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
                InstallPackage::class,
                CreatePermission::class,
                CreateRole::class
            ]);
        }
    }
}

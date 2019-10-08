<?php


namespace AppsLab\Acl;


use AppsLab\Acl\Middleware\YaaMiddleware;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class YetAnotherAclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['router']->aliasMiddleware('role', YaaMiddleware::class);
        $this->registerResources();
        $this->registerBladeExtensions();

        config('yaa.models.permission')::get()->map(function ($permission){
            Gate::define($permission->slug, function ($user) use($permission){
                return $user->hasPermissionTo($permission);
            });
        });
    }

    public function register()
    {
        
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
        Blade::directive('endrole', function (){
            return "<?php endif; ?>";
        });
    }
}
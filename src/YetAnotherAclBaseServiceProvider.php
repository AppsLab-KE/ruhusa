<?php


namespace AppsLab\Acl;


use Illuminate\Support\ServiceProvider;

class YetAnotherAlcBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerResources();
    }

    public function register()
    {
        
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');
    }
}
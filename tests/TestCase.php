<?php


namespace AppsLab\Acl\Tests;

use AppsLab\Acl\YetAnotherAclServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return  [
            YetAnotherAclServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb',[
            'driver' => 'sqlite',
            'database' => ':memory'
        ]);
    }
}
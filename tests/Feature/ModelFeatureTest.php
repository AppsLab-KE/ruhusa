<?php


namespace AppsLab\Acl\Tests\Feature;
use AppsLab\Acl\Models\Role;
use AppsLab\Acl\Tests\TestCase;
use AppsLab\Acl\YetAnotherAclServiceProvider;

class ModelFeatureTest extends TestCase
{
    public function testIsWorking()
    {
        $this->assertTrue(true);
    }

    public function testCanCreateRole()
    {
        $role = new Role();

        dd(config('yaa.models.permission'));

//        $this->assertCount(1, Role::all());
    }
}
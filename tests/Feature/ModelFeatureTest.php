<?php


namespace AppsLab\Acl\Tests\Feature;


use AppsLab\Acl\Models\Role;
use AppsLab\Acl\Tests\TestCase;

class ModelFeatureTest extends TestCase
{
    public function testIsWorking()
    {
        $this->assertTrue(true);
    }

    public function testCanCreateRole()
    {
        $role = new Role();

        dd($role);

//        $this->assertCount(1, Role::all());
    }
}
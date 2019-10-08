<?php


namespace AppsLab\Alc\Tests\Feature;

use AppsLab\Acl\Models\Role;
use AppsLab\Alc\Tests\TestCase;

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
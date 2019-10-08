<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Models
   |--------------------------------------------------------------------------
   |
   | If you want, you can replace default models from this package by models
   | you created.
   |
   */

    'models' => [
        'role'          => '\AppsLab\Acl\Models\Role::class',
        'permission'    => '\AppsLab\Acl\Models\Permission::class',
        'defaultUser'   => config('auth.providers.users.model'),
    ],
    'tables' => [
        'role' => 'roles',
        'permission' => 'permissions'
    ],
    'user_model' => [
        'model' => 'App\User',
        'table' => 'users' //many to many relationship
    ]
];
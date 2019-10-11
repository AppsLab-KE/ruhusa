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
        'role'          => '\AppsLab\Acl\Models\Role',
        'permission'    => '\AppsLab\Acl\Models\Permission',
        'defaultUser'   => config('auth.providers.users.model'),
    ],

    /*
  |--------------------------------------------------------------------------
  | Tables
  |--------------------------------------------------------------------------
  |
  | If you want, you can replace default tables from this package
  |
  */
    'tables' => [
        'role' => 'roles',
        'permission' => 'permissions'
    ]
];
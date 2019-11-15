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
        'role' => "roles",
        'permission' => 'permissions',
        'users_roles' => 'users_roles',
        'users_permissions' => 'users_permissions',
        'roles_permissions' => 'roles_permissions',
    ],
    'perPage' => 15,
    'route-prefix' => 'acl',
    'login-route' => 'login',
    'route-middleware' => 'web',
    'messages' => [
        'no-role' => "Permission denied"
    ]
];
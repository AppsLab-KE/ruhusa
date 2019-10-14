<?php
Route::get('/roles', 'AppsLab\Acl\Http\Controllers\RuhusaController@roles')->name('roles.index');
Route::post('/roles', 'AppsLab\Acl\Http\Controllers\RuhusaController@storeRole')->name('roles.store');
Route::post('/permissions', 'AppsLab\Acl\Http\Controllers\RuhusaController@storePermission')->name('permissions.store');
Route::get('/roles/create', 'AppsLab\Acl\Http\Controllers\RuhusaController@createRole')->name('roles.create');
Route::get('/permissions/create', 'AppsLab\Acl\Http\Controllers\RuhusaController@createPermission')->name('permissions.create');
Route::get('/roles/{role}/edit', 'AppsLab\Acl\Http\Controllers\RuhusaController@editRole')->name('roles.edit');
Route::get('/permissions/{permission}/edit', 'AppsLab\Acl\Http\Controllers\RuhusaController@editPermission')->name('permissions.edit');
Route::put('/roles/{role}/update', 'AppsLab\Acl\Http\Controllers\RuhusaController@updateRole')->name('roles.update');
Route::put('/permissions/{permission}/update', 'AppsLab\Acl\Http\Controllers\RuhusaController@updatePermission')->name('permissions.update');
Route::delete('/permissions/delete/{permission}', 'AppsLab\Acl\Http\Controllers\RuhusaController@deletePermission')->name('permissions.delete');
Route::delete('/roles/delete/{role}', 'AppsLab\Acl\Http\Controllers\RuhusaController@deleteRole')->name('roles.delete');
Route::get('/permissions', 'AppsLab\Acl\Http\Controllers\RuhusaController@permissions')->name('permissions.index');
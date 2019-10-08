<?php


namespace AppsLab\Acl\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'slug','name'
    ];
}
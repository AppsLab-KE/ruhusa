<?php


namespace AppsLab\Acl\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'slug','name'
    ];
}
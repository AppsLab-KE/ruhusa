<?php


namespace AppsLab\Acl\Models;

use AppsLab\Acl\Traits\RoleHasRelation;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use RoleHasRelation;
    protected $table = 'roles';

    protected $fillable = [
        'name', 'slug'
    ];
}
<?php


namespace AppsLab\Acl\Models;


class Permission extends BaseModel
{
    protected $fillable = [
        'slug','name'
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
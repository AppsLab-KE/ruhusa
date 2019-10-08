<?php


namespace AppsLab\Acl\Models;


class Role extends BaseModel
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions','role_id','permission_id');
    }
}
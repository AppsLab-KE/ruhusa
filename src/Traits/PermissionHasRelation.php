<?php


namespace AppsLab\Acl\Traits;


trait PermissionHasRelation
{
    public function users()
    {
        return $this->belongsToMany(config('roles.models.defaultUser'));
    }
    
    public function roles()
    {
        return $this->belongsToMany(config('yaa.models.role'));
    }
}
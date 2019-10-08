<?php


namespace AppsLab\Acl\Traits;


trait RoleHasRelation
{
    public function users()
    {
        return $this->belongsToMany(config('roles.models.defaultUser'));
    }

    public function permissions()
    {
        return $this->belongsToMany(config('yaa.models.role'));
    }
}
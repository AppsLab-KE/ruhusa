<?php


namespace AppsLab\Acl\Traits;


trait PermissionHasRelation
{
    public function users()
    {
        return $this->belongsToMany(config('ruhusa.models.defaultUser'),config('ruhusa.tables.users_permissions'));
    }
    
    public function roles()
    {
        return $this->belongsToMany(config('ruhusa.models.role'), config('ruhusa.tables.roles_permissions'));
    }


}
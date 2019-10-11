<?php

namespace AppsLab\Acl\Traits;

trait HasAcl
{
    public function roles()
    {
        return $this->belongsToMany(config('ala.models.role'));
    }

    public function permissions()
    {
        return $this->belongsToMany(config('ala.models.permission'));
    }

    public function hasRole(... $roles)
    {
        foreach ($roles as $role){
            if ($this->roles->contains('slug', $role)){
                return true;
            }
        }

        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    protected function hasPermission($permission) : bool
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    public function hasPermissionThroughRole($permission) : bool
    {
        foreach ($permission->roles as $role){
            if ($this->roles->contains($role)){
                return true;
            }
        }

        return false;
    }

    public function givePermissionsTo( ... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions !== null){

            $this->permissions()->sync($permissions);
//            $this->permissions()->attach($permissions);
        }

        return $this;
    }

    public function giveRoles( ... $roles )
    {
        $roles = $this->getAllRoles($roles);

        if($roles !== null){
            $this->roles()->attach($roles);
        }
    }

    public function withdrawRoles( ... $roles )
    {
        $this->roles()->detach($this->getAllRoles($roles));
        return $this;
    }

    public function withdrawPermissionsTo( ... $permissions )
    {
        $this->permissions()->detach($this->getAllPermissions($permissions));
        return $this;
    }

    protected function getAllPermissions(array $permissions)
    {
        return config('ala.models.permission')::whereIn('slug', $permissions)->get();
    }

    public function updatePermissions( ... $permissions )
    {
        $this->permissions()->sync($this->getAllPermissions($permissions));
        return $this;
    }

    public function updateRoles( ... $roles )
    {
        $this->roles()->sync($this->getAllRoles($roles));
        return $this;
    }

    protected function getAllRoles(array $roles)
    {
        return config('ala.models.roles')::where('slug', $roles)->get();
    }

}
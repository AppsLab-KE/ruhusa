<?php

namespace AppsLab\Acl\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasAcl
{
    public function roles()
    {
        return $this->belongsToMany(config('ruhusa.models.role'), config('ruhusa.tables.users_roles'));
    }

    public function permissions()
    {
        return $this->belongsToMany(config('ruhusa.models.permission'), config('ruhusa.tables.users_permissions'));
    }

    public function hasRole(... $roles)
    {
        foreach ($this->getRoleIds($roles) as $role){
            if ($this->roles->contains('id', $role)){
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasPermission(['admin']);
    }

    private function getRoleIds(array $roles)
    {
        $roleIds = [];
        foreach ($roles as $role) {
            $roleId = $this->getRoleId($role);
            if ($roleId){
                array_push($roleIds, $roleId);
            }
        }

        return $roleIds;
    }

    private function getRoleId($role)
    {
        $roleModel = app(config('ruhusa.models.role'));
        if (is_numeric($role)){
            return $role;
        }

        if (is_string($role)){
            $role = $roleModel->where('slug', $role)->first();

            return $role != null ? $role->id : false;
        }

        if ($role instanceof Model){
            return $role->id;
        }

        return false;
    }

    public function hasPermissionTo(... $permissions)
    {
        return $this->hasPermissionThroughRole($permissions) || $this->hasPermission($permissions);
    }

    protected function hasPermission(array $permissions) : bool
    {

        foreach ($permissions as $permission) {
            return (bool) $this->permissions->where('id', $this->getPermissionId($permission))->count();
        }

        return false;
    }

    private function getPermissionIds(array $permissions)
    {
        $permissionIds = [];

        foreach ($permissions as $permission) {
            $permissionId = $this->getPermissionId($permission);
            if ($permission){
                array_push($permissionIds, $permissionId);
            }
        }

        return $permissionIds;
    }

    private function getPermissionId($permission)
    {
        $getPermission = null;
        $permModel = app(config('ruhusa.models.permission'));

        if (is_numeric($permission)){
            return $permission;
        }

        if (is_string($permission)){
            $getPermission = $permModel->where('slug', $permission)->first();
        }

        if ($permission instanceof Model){
            $getPermission = $permission->first();
        }

        if ($getPermission != null){
            return $getPermission->id;
        }

        return false;
    }

    public function hasPermissionThroughRole(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            $permModel = app(config('ruhusa.models.permission'))->where('id', $this->getPermissionId($permission))->first();

            if ($permModel){
                foreach ($permModel->roles as $role){
                    if ($this->roles->contains($role)){
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function givePermissionsTo( ... $permissions )
    {
        if (count($permissions)){
            $this->permissions()->sync($this->getPermissionIds($permissions));
        }

        return $this;
    }

    public function giveRoles( ... $roles )
    {
        if(count($roles)){
            $this->roles()->attach($this->getRoleIds($roles));
        }

        return $this;
    }

    public function withdrawRoles( ... $roles )
    {
        $this->roles()->detach($this->getRoleIds($roles));
        return $this;
    }

    public function withdrawPermissionsTo( ... $permissions )
    {
        if (count($permissions)){
            $this->permissions()->detach($this->getPermissionIds($permissions));
        }
        return $this;
    }

    public function updatePermissions( ... $permissions )
    {
        if (count($permissions)){
            $this->permissions()->sync($this->getPermissionIds($permissions));
        }
        return $this;
    }

    public function updateRoles( ... $roles )
    {
        $this->roles()->sync($this->getRoleIds($roles));
        return $this;
    }

}
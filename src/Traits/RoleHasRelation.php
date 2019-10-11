<?php


namespace AppsLab\Acl\Traits;

use Illuminate\Database\Eloquent\Model;

trait RoleHasRelation
{
    public function users()
    {
        return $this->belongsToMany(config('ruhusa.models.defaultUser'), config('ruhusa.tables.users_roles'));
    }

    public function permissions()
    {
        return $this->belongsToMany(config('ruhusa.models.permission'), config('ruhusa.tables.roles_permissions'));
    }

    public function giveRoleToUser(... $users)
    {
        if (count($users)){
            $this->users()->syncWithoutDetaching($this->getUserIds($users));
        }

        return $this;
    }

    protected function getUserIds(array $users)
    {
        $userIds = [];

        foreach ($users as $user){
            array_push($userIds, $this->getUserId($user));
        }

        return $userIds;
    }

    private function getUserId($user)
    {
        if (is_numeric($user)){
            return $user;
        }

        if ($user instanceof Model){
            return $user->first()->id;
        }

        return false;
    }

    public function givePermissions(... $permissions)
    {
        if (count($permissions)){
            foreach ($permissions as $permission){
                $permissionId = $this->getPermissionId($permission);
                if ($permissionId){
                    $this->permissions()->syncWithoutDetaching($permissionId);
                }
            }
        }

        return $this;
    }

    public function syncPermissions(... $permissions)
    {
        if (count($permissions)){
            $permissionIds = [];
            foreach ($permissions as $permission){
                array_push($permissionIds, $this->getPermissionId($permission));
            }

            $this->permissions()->sync($permissionIds);
        }

        return $this;
    }

    public function withdrawPermissions(... $permissions)
    {
        if (count($permissions)){
            $permissionIds = [];

            foreach ($permissions as $permission) {
                array_push($permissionIds, $this->getPermissionId($permission));
            }

            $this->permissions()->detach($permissionIds);
        }

        return $this;
    }

    public function attachAllUsers()
    {
        $userModel = app(config('ruhusa.models.user'));
        $userModel->all()->map(function ($user){
            return $this->giveRoleToUser($user->id);
        });
    }

    public function roleHasPermission($permission)
    {
        $permissionId = $this->getPermissionId($permission);

        if ($permissionId){
            return null !== $this->permissions->where(['id', $permissionId])->first();
        }

        return false;
    }

    private function getPermissionId($permission)
    {
        $permModel = app(config('ruhusa.models.permission'));
        if (is_numeric($permission)){
            return $permission;
        }

        if (is_string($permission)){
            return $permModel->where(['slug', $permission])->first()->id;
        }

        if ($permission instanceof Model){
            return $permModel->where(['slug', $permission->slug])->first()->id;
        }

        return false;
    }

    public function detachAllUsers()
    {
        $this->users()->detach();
        return $this;
    }
}
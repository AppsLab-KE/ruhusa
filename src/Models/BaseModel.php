<?php


namespace AppsLab\Acl\Models;


use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class,'users_roles');
    }
}
<?php


namespace AppsLab\Acl\Models;


use AppsLab\Acl\Traits\PermissionHasRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use PermissionHasRelation, SoftDeletes;
    protected $table;
    protected $dates = [
        'deleted_at'
    ];

    public function __construct()
    {
        $this->table = config('ruhusa.tables.permission');
    }

    protected $fillable = [
        'slug','name','description'
    ];
}
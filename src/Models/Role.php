<?php


namespace AppsLab\Acl\Models;

use AppsLab\Acl\Traits\RoleHasRelation;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use RoleHasRelation;
    protected $table;

    public function __construct()
    {
        $this->table = config('yaa.tables.role');
    }

    protected $fillable = [
        'name', 'slug'
    ];
}
<?php


namespace AppsLab\Acl\Models;

use AppsLab\Acl\Traits\RoleHasRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use RoleHasRelation, SoftDeletes;
    protected $dates = [
        'deleted_at'
    ];
    protected $table;

    public function __construct()
    {
        $this->table = config('ruhusa.tables.role');
    }

    protected $fillable = [
        'name', 'slug','description'
    ];
}
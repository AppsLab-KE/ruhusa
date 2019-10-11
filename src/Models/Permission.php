<?php


namespace AppsLab\Acl\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table;

    public function __construct()
    {
        $this->table = config('ruhusa.tables.permission');
    }

    protected $fillable = [
        'slug','name','description'
    ];
}
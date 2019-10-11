<?php

namespace Appslab\Acl\Command;

use AppsLab\Acl\Exceptions\AlreadyExist;
use Illuminate\Console\Command;

class CreatePermission extends Command
{
    protected $signature = 'make:perm {-n|name} {-s|slug} {-d|description}';

    protected $description = 'This will create permission in permission table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
            $permModel = app(config('ala.models.permission'));

            if ($permModel){
                try{
                    $permission = $permModel->where('slug', $this->argument('slug'))
                        ->orWhere('name', $this->argument('name'))->first();

                    if (! is_null($permission)){
                        throw  AlreadyExist::exception($this->argument('name'));
                    }

                    $permModel->create([
                        'name' => $this->argument('name'),
                        'slug' => $this->argument('slug'),
                        'description' => $this->argument('description')
                    ]);

                    $this->info($this->argument('name'). " permission was created successfully");
                }catch (\Exception $exception){
                    $this->error("Permission was not created");
                }
            }
            else{
                $this->error("Check your permission class on ala config");
            }
    }
}
<?php

namespace Appslab\Acl\Command;

use AppsLab\Acl\Exceptions\AlreadyExist;
use Illuminate\Console\Command;

class CreateRole extends Command
{
    protected $signature = 'make:role {-n|name} {-s|slug} {-d|description}';

    protected $description = 'This will create role in role table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
            $roleModel = app(config('ruhusa.models.role'));

            if ($roleModel){
                try{
                    $role = $roleModel->where('slug', $this->argument('slug'))
                        ->orWhere('name', $this->argument('name'))->first();

                    if (! is_null($role)){
                        throw  AlreadyExist::exception($this->argument('name'). ' role');
                    }

                    $roleModel->create([
                        'name' => $this->argument('name'),
                        'slug' => $this->argument('slug'),
                        'description' => $this->argument('description')
                    ]);

                    $this->info($this->argument('name'). " role was created successfully");
                }catch (\Exception $exception){
                    $this->error("Role was not created");
                }
            }
            else{
                $this->error("Check your role class in ruhusa config");
            }
    }
}
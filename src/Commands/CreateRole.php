<?php

namespace AppsLab\Acl\Commands;

use AppsLab\Acl\Exceptions\AlreadyExist;
use Illuminate\Console\Command;

class CreateRole extends Command
{
    protected $signature = 'make:role {name} {slug?} {desc?}';

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
                $role = $roleModel->where('slug', ($this->argument('slug' ?? str_slug($this->argument('name')))))
                    ->orWhere('name', $this->argument('name'))->first();

                if (! is_null($role)){
                    $this->error("\n This role already exists\n");
                    throw  AlreadyExist::exception($this->argument('name'). ' role');
                }

                $roleModel->create([
                    'name' => $this->argument('name'),
                    'slug' => ($this->argument('slug' ?? str_slug($this->argument('name')))),
                    'description' => $this->argument('desc')
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
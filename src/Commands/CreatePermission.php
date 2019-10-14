<?php

namespace AppsLab\Acl\Commands;

use AppsLab\Acl\Exceptions\AlreadyExist;
use Illuminate\Console\Command;

class CreatePermission extends Command
{
    /**
     * @var string
     */
    protected $signature = 'make:perm {name} {slug?} {desc?}';

    protected $description = 'This will create permission in permission table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $permModel = app(config('ruhusa.models.permission'));

        if ($permModel){
            try{
                $permission = $permModel->where('slug', ($this->argument('slug' ?? str_slug($this->argument('name')))))
                    ->orWhere('name', $this->argument('name'))->first();

                if (!is_null($permission)){
                    $this->error("\nPermission already exists\n");
                    throw  AlreadyExist::exception($this->argument('name').' permission');
                }

                $permModel->create([
                    'name' => $this->argument('name'),
                    'slug' => ($this->argument('slug' ?? str_slug($this->argument('name')))),
                    'description' => $this->argument('desc')
                ]);

                $this->info($this->argument('name'). " permission was created successfully");
            }catch (\Exception $exception){
                $this->error("Permission was not created");
            }
        }
        else{
            $this->error("Check your permission class in ruhusa config");
        }
    }
}
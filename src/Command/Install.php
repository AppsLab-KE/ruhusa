<?php

namespace Appslab\Acl\Command;

use AppsLab\Acl\Exceptions\AlreadyExist;
use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = 'ruhusa:install';

    protected $description = 'This will publish vendor items';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->callSilent('vendor:publish',[
            '--tag' => 'ruhusa'
        ]);

        $this->info("You are ready to go");
        $this->comment("Add HasAcl to your User model: happy debugging 🐛");
    }
}
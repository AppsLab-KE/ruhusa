<?php

namespace AppsLab\Acl\Commands;

use Illuminate\Console\Command;

class InstallPackage extends Command
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
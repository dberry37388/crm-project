<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will reset the application with default seeding';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('scout:flush', ['model' => 'App\Models\Industry']);
        $this->call('scout:flush', ['model' => 'App\Models\Company']);
        $this->call('scout:flush', ['model' => 'App\Models\Contact']);

        $this->call('migrate:fresh', ['--seed' => true]);

        $this->call('scout:import', ['model' => 'App\Models\Company']);
        $this->call('scout:import', ['model' => 'App\Models\Contact']);

        $this->call('mellisearch:update-filterable-attributes');

        return 0;
    }
}

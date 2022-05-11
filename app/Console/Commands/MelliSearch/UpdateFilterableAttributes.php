<?php

namespace App\Console\Commands\MelliSearch;

use Illuminate\Console\Command;
use MeiliSearch\Client;

class UpdateFilterableAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mellisearch:update-filterable-attributes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update filterable attributes for the different indexes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'));

        $client->index('industries_index')->updateFilterableAttributes([
            'team_id',
            'user_id',
            '__soft_deleted',
        ]);
        $this->info('Updated filterable attributes for the industries_index');

        $client->index('companies_index')->updateFilterableAttributes([
            'team_id',
            'industry_id',
            'created_by_id',
            'assigned_to_id',
            '__soft_deleted',
        ]);

        $client->index('contacts_index')->updateFilterableAttributes([
            'team_id',
            'created_by_id',
            'assigned_to_id',
            '__soft_deleted',
        ]);

        $client->index('deals_index')->updateFilterableAttributes([
            'team_id',
            'created_by_id',
            'assigned_to_id',
            '__soft_deleted',
        ]);

        $this->info('Updated filterable attributes for the companies_index');

        $client->index('notes_index')->updateFilterableAttributes([
            'team_id',
            'created_by_id',
            'assigned_to_id',
            '__soft_deleted',
        ]);

        $this->info('Updated filterable attributes for the companies_index');

        return 0;
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class DealModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deals_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('deals', [
                'id',
                'team_id',
                'created_by_id',
                'owned_by_id',
                'type',
                'stage',
                'priority',
                'name',
                'amount',
                'close_date',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }
}

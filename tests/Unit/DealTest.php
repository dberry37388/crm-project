<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class DealTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deals_database_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('deals', [
                'team_id',
                'created_by_id',
                'owned_by_id',
                'type',
                'stage',
                'priority',
                'name',
                'amount',
                'close_date',
            ])
        );
    }
}

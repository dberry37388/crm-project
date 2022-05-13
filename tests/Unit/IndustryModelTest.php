<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class IndustryModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_industries_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('industries', [
                'id',
                'team_id',
                'created_by_id',
                'name',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }
}

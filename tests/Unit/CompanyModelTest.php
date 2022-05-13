<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class CompanyModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_companies_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('companies', [
                'id',
                'team_id',
                'created_by_id',
                'assigned_to_id',
                'name',
                'description',
                'city',
                'state',
                'postal_code',
                'number_of_employees',
                'timezone',
                'industry_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }
}

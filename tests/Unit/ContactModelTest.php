<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class ContactModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_contacts_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('contacts', [
                'id',
                'team_id',
                'created_by_id',
                'assigned_to_id',
                'first_name',
                'last_name',
                'email',
                'job_title',
                'phone_number',
                'mobile_number',
                'description',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }
}

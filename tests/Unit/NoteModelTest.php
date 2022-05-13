<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class NoteModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_notes_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('notes', [
                'id',
                'noteable_type',
                'noteable_id',
                'note',
                'created_by_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tasks_database_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('tasks', [
                'id',
                'taskable_type',
                'taskable_id',
                'task',
                'notes',
                'due_date',
                'priority',
                'created_by_id',
                'assigned_to_id',
                'completed_at',
                'created_at',
                'updated_at',
            ])
        );
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->morphs('taskable');
            $table->string('task', 3000);
            $table->longText('notes')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Low');
            $table->foreignId('assigned_to_id')->nullable()->constrained('users');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};

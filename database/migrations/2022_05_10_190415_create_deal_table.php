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
        Schema::create('deal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('created_by_id')->constrained('users');
            $table->string('name', 1000);
            $table->decimal('amount',2)->default(0.00);
            $table->dateTime('close_date')->nullable();
            $table->foreignId('owner_id')->constrained('users');
            $table->enum('type', config('defaults.deals.types'));
            $table->enum('stage', config('defaults.deals.stages'));
            $table->foreignId('company_id')->constrained('companies');
            $table->enum('priority', config('defaults.priorities'));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal');
    }
};

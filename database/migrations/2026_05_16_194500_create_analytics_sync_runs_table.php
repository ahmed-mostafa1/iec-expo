<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analytics_sync_runs', function (Blueprint $table) {
            $table->id();
            $table->string('status', 20)->index();
            $table->string('property_id')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->boolean('force')->default(false);
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->json('reports')->nullable();
            $table->json('quota')->nullable();
            $table->text('error')->nullable();
            $table->unsignedInteger('rows_imported')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_sync_runs');
    }
};

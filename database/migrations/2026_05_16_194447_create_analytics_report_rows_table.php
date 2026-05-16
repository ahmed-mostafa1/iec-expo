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
        Schema::create('analytics_report_rows', function (Blueprint $table) {
            $table->id();
            $table->string('report', 40);
            $table->date('date');
            $table->string('dimension_hash', 40);
            $table->json('dimensions');
            $table->text('label');
            $table->unsignedBigInteger('active_users')->default(0);
            $table->unsignedBigInteger('sessions')->default(0);
            $table->unsignedBigInteger('screen_page_views')->default(0);
            $table->unsignedBigInteger('event_count')->default(0);
            $table->decimal('key_events', 16, 4)->default(0);
            $table->timestamps();

            $table->unique(['report', 'date', 'dimension_hash']);
            $table->index(['report', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_report_rows');
    }
};

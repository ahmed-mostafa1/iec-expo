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
        Schema::create('analytics_daily_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->unsignedBigInteger('active_users')->default(0);
            $table->unsignedBigInteger('new_users')->default(0);
            $table->unsignedBigInteger('sessions')->default(0);
            $table->unsignedBigInteger('screen_page_views')->default(0);
            $table->unsignedBigInteger('event_count')->default(0);
            $table->decimal('key_events', 16, 4)->default(0);
            $table->decimal('average_session_duration', 12, 4)->default(0);
            $table->decimal('engagement_rate', 8, 4)->default(0);
            $table->unsignedInteger('sponsor_registrations')->default(0);
            $table->unsignedInteger('icon_registrations')->default(0);
            $table->unsignedInteger('visitor_registrations')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_daily_stats');
    }
};

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
        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->timestamp('ticket_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->dropColumn('ticket_sent_at');
        });
    }
};

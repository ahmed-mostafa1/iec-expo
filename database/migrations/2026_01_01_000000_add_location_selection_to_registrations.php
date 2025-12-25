<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->string('location_selection')->nullable()->after('organization');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->string('location_selection')->nullable()->after('organization');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->dropColumn('location_selection');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->dropColumn('location_selection');
        });
    }
};

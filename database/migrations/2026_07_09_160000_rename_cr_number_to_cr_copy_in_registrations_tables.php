<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_number', 'cr_copy');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_number', 'cr_copy');
        });

        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_number', 'cr_copy');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_copy', 'cr_number');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_copy', 'cr_number');
        });

        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->renameColumn('cr_copy', 'cr_number');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->string('cr_number')->nullable()->after('cr_copy_path');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->string('cr_number')->nullable()->after('cr_copy_path');
        });

        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->string('cr_number')->nullable()->after('cr_copy_path');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->dropColumn('cr_number');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->dropColumn('cr_number');
        });

        Schema::table('icon_plus_registrations', function (Blueprint $table) {
            $table->dropColumn('cr_number');
        });
    }
};

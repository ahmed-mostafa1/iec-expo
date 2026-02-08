<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->string('vat_certificate_path')->nullable()->after('vat_number');
            $table->string('vat_number')->nullable()->change();
            $table->dropColumn('cr_number');
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->string('vat_certificate_path')->nullable()->after('vat_number');
            $table->string('vat_number')->nullable()->change();
            $table->dropColumn('cr_number');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->dropColumn('vat_certificate_path');
            $table->string('cr_number')->index();
        });

        Schema::table('icon_registrations', function (Blueprint $table) {
            $table->dropColumn('vat_certificate_path');
            $table->string('cr_number')->index();
        });
    }
};

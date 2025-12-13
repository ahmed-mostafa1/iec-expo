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
        Schema::table('visitor_registrations', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('phone');
        });

        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->string('cr_copy_path')->nullable()->after('document_path');
            $table->string('national_address_doc_path')->nullable()->after('cr_copy_path');
            $table->string('company_logo_path')->nullable()->after('national_address_doc_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_registrations', function (Blueprint $table) {
            $table->dropColumn('job_title');
        });

        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'cr_copy_path',
                'national_address_doc_path',
                'company_logo_path',
            ]);
        });
    }
};

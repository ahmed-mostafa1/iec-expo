<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('icon_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('job_title');
            $table->string('organization');
            $table->string('vat_number')->nullable()->index();
            $table->string('cr_number')->nullable()->index();
            $table->text('national_address')->nullable();
            $table->string('document_path')->nullable();
            $table->string('cr_copy_path')->nullable();
            $table->string('national_address_doc_path')->nullable();
            $table->string('company_logo_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icon_registrations');
    }
};

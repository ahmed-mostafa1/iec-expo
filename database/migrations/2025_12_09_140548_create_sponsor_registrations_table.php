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
        Schema::create('sponsor_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('job_title');
            $table->string('organization');
            $table->string('vat_number')->index();
            $table->string('cr_number')->index();
            $table->text('national_address');
            $table->string('document_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('pending'); // pending/approved/rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_registrations');
    }
};

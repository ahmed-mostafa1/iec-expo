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
        Schema::create('visitor_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('company_name');
            $table->string('company_predefined')->nullable();
            $table->boolean('company_is_other')->default(false);
            $table->string('heard_about'); // social_media, ads, friends, other
            $table->text('heard_about_other_text')->nullable();
            $table->text('interests')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_registrations');
    }
};

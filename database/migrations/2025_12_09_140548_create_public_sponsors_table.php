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
        Schema::create('public_sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path');
            $table->string('tier')->nullable(); // main, gold, silver, etc.
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_sponsors');
    }
};
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
        Schema::table('public_sponsors', function (Blueprint $table) {
            $table->dropColumn(['url', 'description_en', 'description_ar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_sponsors', function (Blueprint $table) {
            $table->string('url')->nullable()->after('tier');
            $table->text('description_en')->nullable()->after('url');
            $table->text('description_ar')->nullable()->after('description_en');
        });
    }
};

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
    Schema::create('hero_media', function (Blueprint $table) {
        $table->id();
        $table->string('title_en')->nullable();
        $table->string('title_ar')->nullable();
        $table->text('subtitle_en')->nullable();
        $table->text('subtitle_ar')->nullable();
        $table->string('video_type'); // url or file
        $table->string('video_url')->nullable();
        $table->string('video_path')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_media');
    }
};

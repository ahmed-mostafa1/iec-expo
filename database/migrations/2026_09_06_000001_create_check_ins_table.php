<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->string('registrant_type');
            $table->unsignedBigInteger('registrant_id');
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->timestamp('scanned_at');
            $table->timestamps();

            $table->index(['registrant_type', 'registrant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};

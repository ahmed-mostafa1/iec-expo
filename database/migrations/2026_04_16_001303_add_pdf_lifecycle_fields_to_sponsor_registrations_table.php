<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->string('pdf_status')->default('pending');
            $table->text('pdf_error')->nullable();
            $table->timestamp('pdf_generated_at')->nullable();
        });

        DB::table('sponsor_registrations')
            ->whereNotNull('pdf_path')
            ->update([
                'pdf_status' => 'generated',
            ]);
    }

    public function down(): void
    {
        Schema::table('sponsor_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'pdf_status',
                'pdf_error',
                'pdf_generated_at',
            ]);
        });
    }
};

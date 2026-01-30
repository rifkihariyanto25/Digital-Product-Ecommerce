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
        Schema::table('qna_sections', function (Blueprint $table) {
            $table->text('question')->after('id');
            $table->text('answer')->after('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qna_sections', function (Blueprint $table) {
            $table->dropColumn(['question', 'answer']);
        });
    }
};

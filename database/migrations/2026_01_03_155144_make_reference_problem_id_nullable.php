<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('references', function (Blueprint $table) {
            // drop FK first
            $table->dropForeign(['problem_id']);

            // make column nullable
            $table->foreignId('problem_id')
                  ->nullable()
                  ->change();

            // re-add FK
            $table->foreign('problem_id')
                  ->references('id')
                  ->on('problems')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('references', function (Blueprint $table) {
            $table->dropForeign(['problem_id']);

            $table->foreignId('problem_id')
                  ->nullable(false)
                  ->change();

            $table->foreign('problem_id')
                  ->references('id')
                  ->on('problems')
                  ->cascadeOnDelete();
        });
    }
};

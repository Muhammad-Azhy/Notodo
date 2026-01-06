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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');

            // Define foreign key after the column
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreign('reference_id')
                  ->references('id')
                  ->on('references')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            // Drop foreign key first before dropping table
            $table->dropForeign(['reference_id']);
        });
        Schema::dropIfExists('attachments');
    }
};

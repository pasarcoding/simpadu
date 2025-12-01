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
        Schema::create('e_letter_templates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedBigInteger('last_sequence_number')->default(0);
            $table->unsignedTinyInteger('padding_sequence_length')->default(1);
            $table->text('list_variables');
            $table->text('file');
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_letter_templates');
    }
};

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
        Schema::create('e_letter_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('e_letter_template_id')->constrained('e_letter_templates', 'id')->cascadeOnDelete()->cascadeOnDelete();
            $table->foreignId('resident_id')->nullable()->constrained('residents', 'id')->cascadeOnDelete()->cascadeOnDelete();
            $table->string('national_id');
            $table->string('letter_number');
            $table->text('list_variable_with_values');
            $table->string('whatsapp_number');
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_letter_submissions');
    }
};

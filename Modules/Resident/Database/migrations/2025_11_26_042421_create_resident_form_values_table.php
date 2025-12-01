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
        Schema::create('resident_form_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')->constrained('residents', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('resident_form_id')->constrained('resident_forms', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('value')->nullable();

            $table->unique(['resident_id', 'resident_form_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_form_values');
    }
};

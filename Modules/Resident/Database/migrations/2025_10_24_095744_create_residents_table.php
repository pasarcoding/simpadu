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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            $table->string('national_id')->unique();
            $table->string('full_name');
            $table->string('gender');
            $table->string('birth_place');
            $table->date('birth_date');

            $table->string('religion');
            $table->string('job');
            $table->string('other_job')->nullable();
            $table->string('last_education');
            $table->string('marital_status');
            $table->string('family_relationship');

            $table->string('family_card_number');
            $table->string('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('hamlet_village')->nullable();

            $table->string('death_status');
            $table->date('transfer_date')->nullable();
            $table->string('citizenship');

            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

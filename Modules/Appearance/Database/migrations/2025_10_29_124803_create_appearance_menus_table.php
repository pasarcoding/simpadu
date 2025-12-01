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
        Schema::create('appearance_menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')->nullable()->constrained('appearance_menus', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->text('url')->nullable();
            $table->string('type');
            $table->string('behaviour_target');
            $table->string('page_origin');
            $table->foreignId('appearance_page_id')->nullable()->constrained('appearance_pages', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('default_page_id')->nullable();
            $table->string('order');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appearance_menus');
    }
};

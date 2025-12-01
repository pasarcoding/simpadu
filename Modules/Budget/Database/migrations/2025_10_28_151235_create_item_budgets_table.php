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
        Schema::create('item_budgets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('budget_id')->constrained('budgets', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nominal');
            $table->string('type');
            $table->text('note');
            $table->date('payment_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_budgets');
    }
};

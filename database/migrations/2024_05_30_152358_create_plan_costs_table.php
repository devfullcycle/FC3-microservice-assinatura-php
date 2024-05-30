<?php

use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
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
        Schema::create('plan_costs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('price', 11, 4);
            $table->enum('recurrence_period', array_column(RecurrencePeriodEnum::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_costs');
    }
};

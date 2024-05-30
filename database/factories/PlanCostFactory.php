<?php

namespace Database\Factories;

use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanCost>
 */
class PlanCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'price' => 1.00,
            'recurrence_period' => fake()->randomElement(array_column(RecurrencePeriodEnum::cases(), 'value')),
        ];
    }
}

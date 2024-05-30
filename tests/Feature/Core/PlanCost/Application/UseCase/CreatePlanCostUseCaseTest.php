<?php

use Core\PlanCost\Application\DTO\CreatePlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\UseCase\CreatePlanCostUseCase;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

use function Pest\Laravel\assertDatabaseHas;

test('should create planCost', function () {
    $repository = app(PlanCostRepositoryInterface::class);
    $useCase = new CreatePlanCostUseCase($repository);

    $response = $useCase->execute(new CreatePlanCostDTO(1.00, RecurrencePeriodEnum::MONTHLY));

    expect($response)->toBeInstanceOf(OutputPlanCostDTO::class);
    expect($response->price)->toBe(1.00);
    expect($response->recurrence_period)->toBe('monthly');
    expect($response->id)->not->toBeNull();
    assertDatabaseHas('plan_costs', ['price' => 1.00, 'recurrence_period' => 'monthly']);
});

<?php

use App\Models\PlanCost as Model;
use Core\PlanCost\Application\DTO\EditPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\UseCase\EditPlanCostUseCase;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => $this->useCase = new EditPlanCostUseCase(app(PlanCostRepositoryInterface::class)));

test('should edit planCost', function () {
    $planCostFactory = Model::factory()->create();

    $response = $this->useCase->execute(new EditPlanCostDTO(
        id: $planCostFactory->id,
        price: 2.00,
    ));

    expect($response)->toBeInstanceOf(OutputPlanCostDTO::class);
    expect($response->id)->toBe($planCostFactory->id);
    expect($response->price)->toBe(2.00);

    assertDatabaseHas('plan_costs', [
        'id' => $planCostFactory->id,
        'price' => 2.00,
    ]);
});

test('should throws exception when planCost not found', function () {
    $this->useCase->execute(new EditPlanCostDTO(
        id: 'fake_id',
        price: 4.00,
    ));
})->throws(EntityNotFoundException::class);

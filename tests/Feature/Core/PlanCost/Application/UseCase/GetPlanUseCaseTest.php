<?php

use App\Models\PlanCost as Model;
use Core\PlanCost\Application\DTO\InputPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\UseCase\GetPlanCostUseCase;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

beforeEach(fn () => $this->useCase = new GetPlanCostUseCase(app(PlanCostRepositoryInterface::class)));

test('should return planCost', function () {
    $planCostFactory = Model::factory()->create();

    $response = $this->useCase->execute(new InputPlanCostDTO(id: $planCostFactory->id));

    expect($response)->toBeInstanceOf(OutputPlanCostDTO::class);
    expect($response->id)->toBe($planCostFactory->id);
    expect($response->price)->toBe($planCostFactory->price);
});

test('should throws exception when planCost not found', function () {
    $this->useCase->execute(new InputPlanCostDTO(id: 'fake_id'));
})->throws(EntityNotFoundException::class);

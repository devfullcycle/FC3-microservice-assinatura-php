<?php

use App\Models\PlanCost as Model;
use Core\PlanCost\Application\DTO\InputFindAllPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputFindAllPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\UseCase\FindAllPlansCostUseCase;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

beforeEach(fn () => $this->useCase = new FindAllPlansCostUseCase(app(PlanCostRepositoryInterface::class)));

test('should return all plansCost', function () {
    Model::factory(10)->create();

    $response = $this->useCase->execute(new InputFindAllPlansCostDTO());

    expect($response)->toBeInstanceOf(OutputFindAllPlansCostDTO::class);
    expect($response->total)->toBe(10);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(OutputPlanCostDTO::class), $response->items);
});

test('should return all plansCost - empty', function () {
    $response = $this->useCase->execute(new InputFindAllPlansCostDTO());

    expect($response)->toBeInstanceOf(OutputFindAllPlansCostDTO::class);
    expect($response->total)->toBe(0);
});

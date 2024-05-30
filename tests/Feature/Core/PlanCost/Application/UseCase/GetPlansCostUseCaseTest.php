<?php

use App\Models\PlanCost as Model;
use Core\PlanCost\Application\DTO\InputPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlansCostDTO;
use Core\PlanCost\Application\UseCase\GetPlansCostUseCase;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

beforeEach(fn () => $this->useCase = new GetPlansCostUseCase(app(PlanCostRepositoryInterface::class)));

test('should get planCosts with paginate', function () {
    Model::factory()->count(50)->create();

    $response = $this->useCase->execute(new InputPlansCostDTO());

    expect($response)->toBeInstanceOf(OutputPlansCostDTO::class);
    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(50);
    expect($response->last_page)->toBe(4);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
    array_map(fn ($dtoOutput) => expect($dtoOutput)->toBeInstanceOf(OutputPlanCostDTO::class), $response->items);
});

test('should get planCosts with paginate (page 2)', function () {
    Model::factory()->count(50)->create();

    $response = $this->useCase->execute(new InputPlansCostDTO(
        page: 2
    ));

    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(50);
    expect($response->last_page)->toBe(4);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(3);
    expect($response->previous_page)->toBe(1);
});

test('should get planCosts with paginate (with total per page)', function () {
    Model::factory()->count(60)->create();

    $response = $this->useCase->execute(new InputPlansCostDTO(
        totalPerPage: 20
    ));

    expect(count($response->items))->toBe(20);
    expect($response->total)->toBe(60);
    expect($response->last_page)->toBe(3);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
});

test('should get planCosts with paginate (empty)', function () {
    $response = $this->useCase->execute(new InputPlansCostDTO());

    expect(count($response->items))->toBe(0);
    expect($response->total)->toBe(0);
    expect($response->last_page)->toBe(1);
    expect($response->first_page)->toBeNull();
    expect($response->next_page)->toBeNull();
    expect($response->previous_page)->toBeNull();
});

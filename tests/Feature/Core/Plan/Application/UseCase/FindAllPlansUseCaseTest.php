<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\InputFindAllPlansDTO;
use Core\Plan\Application\DTO\OutputFindAllPlansDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\FindAllPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

beforeEach(fn () => $this->useCase = new FindAllPlansUseCase(app(PlanRepositoryInterface::class)));

test('should return all plans', function () {
    Model::factory(10)->create();

    $response = $this->useCase->execute(new InputFindAllPlansDTO());

    expect($response)->toBeInstanceOf(OutputFindAllPlansDTO::class);
    expect($response->total)->toBe(10);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(OutputPlanDTO::class), $response->items);
});

test('should return all plans - with filter', function () {
    Model::factory(10)->create();
    Model::factory(10)->create(['name' => 'plan filter']);

    $response = $this->useCase->execute(new InputFindAllPlansDTO(
        filter: 'plan filter'
    ));

    expect($response->total)->toBe(10);
    array_map(fn ($entity) => expect($entity->name)->toBe('plan filter'), $response->items);
});

test('should return all plans - empty', function () {
    $response = $this->useCase->execute(new InputFindAllPlansDTO());

    expect($response)->toBeInstanceOf(OutputFindAllPlansDTO::class);
    expect($response->total)->toBe(0);
});

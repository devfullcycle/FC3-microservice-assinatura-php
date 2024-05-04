<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\InputPlansDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Application\UseCase\GetPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

beforeEach(fn () => $this->useCase = new GetPlansUseCase(app(PlanRepositoryInterface::class)));

test('should get plans with paginate', function () {
    Model::factory()->count(50)->create();

    $response = $this->useCase->execute(new InputPlansDTO());

    expect($response)->toBeInstanceOf(OutputPlansDTO::class);
    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(50);
    expect($response->last_page)->toBe(4);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
    array_map(fn ($dtoOutput) => expect($dtoOutput)->toBeInstanceOf(OutputPlanDTO::class), $response->items);
});

test('should get plans with paginate (page 2)', function () {
    Model::factory()->count(50)->create();

    $response = $this->useCase->execute(new InputPlansDTO(
        page: 2
    ));

    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(50);
    expect($response->last_page)->toBe(4);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(3);
    expect($response->previous_page)->toBe(1);
});


test('should get plans with paginate (with filter)', function () {
    Model::factory()->count(25)->create();
    Model::factory()->count(25)->create(['name' => 'plan filter']);

    $response = $this->useCase->execute(new InputPlansDTO(
        filter: 'plan filter'
    ));

    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(25);
    expect($response->last_page)->toBe(2);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
});

test('should get plans with paginate (with total per page)', function () {
    Model::factory()->count(60)->create();

    $response = $this->useCase->execute(new InputPlansDTO(
        totalPerPage: 20
    ));

    expect(count($response->items))->toBe(20);
    expect($response->total)->toBe(60);
    expect($response->last_page)->toBe(3);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
});

test('should get plans with paginate (empty)', function () {
    $response = $this->useCase->execute(new InputPlansDTO());

    expect(count($response->items))->toBe(0);
    expect($response->total)->toBe(0);
    expect($response->last_page)->toBe(1);
    expect($response->first_page)->toBeNull();
    expect($response->next_page)->toBeNull();
    expect($response->previous_page)->toBeNull();
});

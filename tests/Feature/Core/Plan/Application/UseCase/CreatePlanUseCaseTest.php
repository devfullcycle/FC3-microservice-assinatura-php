<?php

use Core\Plan\Application\DTO\CreatePlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\CreatePlanUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

use function Pest\Laravel\assertDatabaseHas;

test('should create plan', function () {
    $repository = app(PlanRepositoryInterface::class);
    $useCase = new CreatePlanUseCase($repository);

    $response = $useCase->execute(new CreatePlanDTO('name', 'description'));

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->name)->toBe('name');
    expect($response->description)->toBe('description');
    expect($response->id)->not->toBeNull();
    assertDatabaseHas('plans', ['name' => 'name', 'description' => 'description']);
});

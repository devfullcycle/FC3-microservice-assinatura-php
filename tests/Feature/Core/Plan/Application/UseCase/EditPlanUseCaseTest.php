<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\EditPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\EditPlanUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => $this->useCase = new EditPlanUseCase(app(PlanRepositoryInterface::class)));

test('should edit plan', function () {
    $planFactory = Model::factory()->create();

    $response = $this->useCase->execute(new EditPlanDTO(
        id: $planFactory->id,
        name: 'test name',
        description: 'test description',
    ));

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->id)->toBe($planFactory->id);
    expect($response->name)->toBe('test name');
    expect($response->description)->toBe('test description');

    assertDatabaseHas('plans', [
        'id' => $planFactory->id,
        'name' => 'test name',
        'description' => 'test description',
    ]);
});

test('should throws exception when plan not found', function () {
    $this->useCase->execute(new EditPlanDTO(
        id: 'fake_id',
        name: 'test name',
        description: 'test description',
    ));
})->throws(EntityNotFoundException::class);

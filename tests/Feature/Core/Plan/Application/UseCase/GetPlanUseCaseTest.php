<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\GetPlanUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

beforeEach(fn () => $this->useCase = new GetPlanUseCase(app(PlanRepositoryInterface::class)));

test('should return plan', function () {
    $planFactory = Model::factory()->create();

    $response = $this->useCase->execute(new InputPlanDTO(id: $planFactory->id));

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->id)->toBe($planFactory->id);
    expect($response->name)->toBe($planFactory->name);
    expect($response->description)->toBe($planFactory->description);
});

test('should throws exception when plan not found', function () {
    $this->useCase->execute(new InputPlanDTO(id: 'fake_id'));
})->throws(EntityNotFoundException::class);

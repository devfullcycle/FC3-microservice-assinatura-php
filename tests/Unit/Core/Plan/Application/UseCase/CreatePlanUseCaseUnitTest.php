<?php

use Core\Plan\Application\DTO\CreatePlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\CreatePlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

test('should create new plan', function () {
    $dto = new CreatePlanDTO(
        name: 'plan name',
        description: 'plan description',
    );
    $plan = new Plan($dto->name, $dto->description);
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('insert')
        ->times(1)
        ->andReturn($plan);
    $useCase = new CreatePlanUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(dto: $dto);

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->name)->toBe($dto->name);
    expect($response->description)->toBe($dto->description);
});

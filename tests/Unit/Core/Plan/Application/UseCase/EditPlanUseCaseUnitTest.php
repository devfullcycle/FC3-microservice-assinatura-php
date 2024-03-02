<?php

use Core\Plan\Application\DTO\EditPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\EditPlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\ValueObjects\Uuid;

test('should edit plan', function () {
    $uuid = Uuid::random();
    $dto = new EditPlanDTO(
        id: (string) $uuid,
        name: 'name update',
        description: 'description update',
    );
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('update')
                    ->times(1)
                    ->andReturn(new Plan($dto->name, $dto->description));
    $mockRepository->shouldReceive('findById')
                    ->times(1)
                    ->andReturn(new Plan('name', 'description', $uuid));
    $useCase = new EditPlanUseCase(
        repository: $mockRepository,
    );
    $response = $useCase->execute(
        input: $dto
    );

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->name)->toBe($dto->name);
    expect($response->description)->toBe($dto->description);
});

test('should throw not found exception', function () {
    $uuid = Uuid::random();
    $dto = new EditPlanDTO(
        id: (string) $uuid,
        name: 'name update',
        description: 'description update',
    );
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('findById')
                    ->times(1)
                    ->andThrows(new EntityNotFoundException('Plan not found'));
    $useCase = new EditPlanUseCase(
        repository: $mockRepository
    );
    $useCase->execute(input: $dto);
})->throws(EntityNotFoundException::class);

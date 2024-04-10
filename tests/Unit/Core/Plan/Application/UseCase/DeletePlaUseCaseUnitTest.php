<?php

use Core\Plan\Application\DTO\DeleteOutputPlanDTO;
use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\UseCase\DeletePlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\ValueObjects\Uuid;

test('should delete a plan', function () {
    $uuid = Uuid::random();
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('delete')
        ->times(1)
        ->with((string) $uuid)
        ->andReturn(true);
    $mockRepository->shouldReceive('findById')
        ->times(1)
        ->andReturn(new Plan('name', 'description', $uuid));
    $useCase = new DeletePlanUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(
        input: new InputPlanDTO(
            id: $uuid
        )
    );
    expect($response)->toBeInstanceOf(DeleteOutputPlanDTO::class);
    expect($response->deleted)->toBeTrue();
});

test('should delete a plan - return false', function () {
    $uuid = Uuid::random();
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('delete')
        ->times(1)
        ->with((string) $uuid)
        ->andReturn(false);
    $mockRepository->shouldReceive('findById')
        ->times(1)
        ->andReturn(new Plan('name', 'description', $uuid));
    $useCase = new DeletePlanUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(
        input: new InputPlanDTO(
            id: $uuid
        )
    );
    expect($response)->toBeInstanceOf(DeleteOutputPlanDTO::class);
    expect($response->deleted)->toBeFalse();
});

test('should throw an exception when plan not found', function () {
    $uuid = Uuid::random();
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('findById')
        ->times(1)
        ->andThrow(new EntityNotFoundException('Plan not found'));
    $useCase = new DeletePlanUseCase(
        repository: $mockRepository
    );
    $useCase->execute(
        input: new InputPlanDTO(
            id: $uuid
        )
    );
})->throws(EntityNotFoundException::class);

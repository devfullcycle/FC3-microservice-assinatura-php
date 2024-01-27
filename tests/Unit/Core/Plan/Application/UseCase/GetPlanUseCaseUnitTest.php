<?php

use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\GetPlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PaginationInterface;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\ValueObjects\Uuid;

test('should return plan', function () {
    $dto = new InputPlanDTO(
        id: '123.123.3212'
    );

    $idEntityPlan = Uuid::random();
    $mockEntityPlan = Mockery::mock(Plan::class, [
        'name_plan', 'description_plan', $idEntityPlan
    ]);
    $mockEntityPlan->shouldReceive('id')->andReturn((string) $idEntityPlan);

    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('findById')
                    ->times(1)
                    ->with($dto->id)
                    ->andReturn($mockEntityPlan);
    $useCase = new GetPlanUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(input: $dto);

    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
    expect($response->id)->toBe((string) $idEntityPlan);
    expect($response->id)->toBeString();
    expect($response->name)->toBe('name_plan');
    expect($response->description)->toBe('description_plan');
});

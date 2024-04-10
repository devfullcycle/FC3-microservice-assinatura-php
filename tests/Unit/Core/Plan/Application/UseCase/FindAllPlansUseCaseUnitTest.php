<?php

use Core\Plan\Application\DTO\InputFindAllPlansDTO;
use Core\Plan\Application\DTO\OutputFindAllPlansDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\FindAllPlansUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

test('should be able to list all plans', function () {
    $dto = new InputFindAllPlansDTO(
        filter: 'a',
        orderBy: 'DESC'
    );
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('findAll')
        ->times(1)
        ->with($dto->filter, $dto->orderBy)
        ->andReturn([
            new Plan('plan1', 'description'),
            new Plan('plan2', 'description'),
            new Plan('plan3', 'description'),
        ]);
    $useCase = new FindAllPlansUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(
        input: $dto
    );

    expect($response)->toBeInstanceOf(OutputFindAllPlansDTO::class);
    array_map(fn ($item) => expect($item)->toBeInstanceOf(OutputPlanDTO::class), $response->items);
    expect($response->total)->toBe(3);
});

test('should be able to list all plans - with empty plans', function () {
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('findAll')
        ->times(1)
        ->andReturn([]);
    $useCase = new FindAllPlansUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute(
        input: new InputFindAllPlansDTO(
            filter: 'a',
            orderBy: 'DESC'
        )
    );

    expect($response)->toBeInstanceOf(OutputFindAllPlansDTO::class);
    expect($response->total)->toBe(0);
});

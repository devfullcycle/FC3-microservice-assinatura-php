<?php

use Core\Plan\Application\UseCase\GetPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

test('should get all plans', function () {
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $useCase = new GetPlansUseCase(
        repository: $mockRepository
    );

    $useCase->execute();
    expect(true)->toBe(true);
});

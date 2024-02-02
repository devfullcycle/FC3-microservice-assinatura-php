<?php

use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Application\UseCase\GetPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Tests\Stubs\PaginationStub;

test('should get all plans', function () {
    $stubPagination = new PaginationStub();
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('paginate')
                ->times(1)
                ->andReturn($stubPagination);
    $useCase = new GetPlansUseCase(
        repository: $mockRepository
    );

    $response = $useCase->execute();
    expect($response)->toBeInstanceOf(OutputPlansDTO::class);
});

<?php

use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\UseCase\CreatePlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

test('should create new plan', function () {
    $plan = new Plan('name', 'description');
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('insert')
                ->times(1)
                // ->with($inputDto->filter, $inputDto->orderBy, $inputDto->page, $inputDto->totalPerPage)
                ->andReturn($plan);
    $useCase = new CreatePlanUseCase(
        repository: $mockRepository
    );
    $response = $useCase->execute();
    
    expect($response)->toBeInstanceOf(OutputPlanDTO::class);
});

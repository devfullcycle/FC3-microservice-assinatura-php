<?php

use Core\Plan\Application\DTO\InputPlansDTO;
use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Application\UseCase\GetPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Tests\Stubs\PaginationStub;

test('should get all plans', function () {
    $inputDto = new InputPlansDTO(
        filter: 'filter',
        orderBy: 'ASC',
        page: 2,
        totalPerPage: 10
    );
    $stubPagination = new PaginationStub();
    $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
    $mockRepository->shouldReceive('paginate')
                ->times(1)
                ->with($inputDto->filter, $inputDto->orderBy, $inputDto->page, $inputDto->totalPerPage)
                ->andReturn($stubPagination);
    $useCase = new GetPlansUseCase(
        repository: $mockRepository
    );

    $response = $useCase->execute(input: $inputDto);
    expect($response)->toBeInstanceOf(OutputPlansDTO::class);
    expect($response->items)->toBeArray();
    expect($response->last_page)->toBe(1);
    expect($response->first_page)->toBe(1);
    expect($response->total_per_page)->toBe(15);
    expect($response->next_page)->toBe(1);
    expect($response->previous_page)->toBe(1);
});

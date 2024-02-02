<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class GetPlansUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(): OutputPlansDTO
    {
        $response = $this->repository->paginate();

        return new OutputPlansDTO(
            items: $response->items(),
            total: $response->total(),
            lastPage: $response->lastPage(),
            firstPage: $response->firstPage(),
            totalPerPage: $response->totalPerPage(),
            nextPage: $response->nextPage(),
            previousPage: $response->previousPage(),
        );
    }
}

<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\InputPlansDTO;
use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class GetPlansUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(InputPlansDTO $input): OutputPlansDTO
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            orderBy: $input->orderBy,
            page: $input->page,
            totalPerPage: $input->totalPerPage
        );

        return new OutputPlansDTO(
            items: $response->items(),
            total: $response->total(),
            last_page: $response->lastPage(),
            first_page: $response->firstPage(),
            total_per_page: $response->totalPerPage(),
            next_page: $response->nextPage(),
            previous_page: $response->previousPage(),
        );
    }
}

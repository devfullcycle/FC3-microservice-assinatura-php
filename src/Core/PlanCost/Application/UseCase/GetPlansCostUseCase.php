<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\InputPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlansCostDTO;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class GetPlansCostUseCase
{
    public function __construct(private PlanCostRepositoryInterface $repository)
    {
    }

    public function execute(InputPlansCostDTO $input): OutputPlansCostDTO
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            orderBy: $input->orderBy,
            page: $input->page,
            totalPerPage: $input->totalPerPage
        );

        return new OutputPlansCostDTO(
            items: $this->convertStdClassToDTO($response->items()),
            total: $response->total(),
            last_page: $response->lastPage(),
            first_page: $response->firstPage(),
            total_per_page: $response->totalPerPage(),
            next_page: $response->nextPage(),
            previous_page: $response->previousPage(),
        );
    }

    /**
     * @return array<OutputPlanCostDTO>
     */
    private function convertStdClassToDTO(array $items = []): array
    {
        return array_map(function ($stdClass) {
            return new OutputPlanCostDTO(
                id: $stdClass->id,
                price: $stdClass->price,
                recurrence_period: $stdClass->recurrence_period,
            );
        }, $items);
    }
}

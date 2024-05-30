<?php

namespace Core\PlanCost\Domain\Repositories;

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\SeedWork\Domain\Repositories\PaginationInterface;

interface PlanCostRepositoryInterface
{
    public function insert(PlanCost $planCost): PlanCost;

    public function findById(string $id): PlanCost;

    /**
     * @return PlanCost[]
     */
    public function findAll(string $filter = '', string $orderBy = 'DESC'): array;

    public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface;

    public function update(PlanCost $planCost): ?PlanCost;

    public function delete(string $id): bool;
}

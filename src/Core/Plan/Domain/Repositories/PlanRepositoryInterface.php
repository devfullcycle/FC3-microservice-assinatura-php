<?php

namespace Core\Plan\Domain\Repositories;

use Core\Plan\Domain\Entities\Plan;

interface PlanRepositoryInterface
{
    public function insert(Plan $plan): Plan;

    public function findById(string $id): Plan;

    /**
     * @return stdClass[]
     */
    public function findAll(string $filter = '', string $orderBy = 'DESC'): array;

    public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface;

    public function update(Plan $plan): Plan;

    public function delete(string $id): bool;
}

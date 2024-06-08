<?php

namespace Core\User\Domain\Repositories;

use Core\SeedWork\Domain\Repositories\PaginationInterface;
use Core\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function insert(User $plan): User;

    public function findById(string $id): User;

    /**
     * @return User[]
     */
    public function findAll(string $filter = '', string $orderBy = 'DESC'): array;

    public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface;

    public function update(User $plan): ?User;

    public function delete(string $id): bool;
}

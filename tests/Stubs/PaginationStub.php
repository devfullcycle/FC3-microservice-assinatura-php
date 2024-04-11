<?php

namespace Tests\Stubs;

use Core\Plan\Domain\Repositories\PaginationInterface;

class PaginationStub implements PaginationInterface
{
    public function __construct(private array $items = [])
    {
    }

    /**
     * @return array<Plan>
     */
    public function items(): array
    {
        return $this->items ?? [];
    }

    public function total(): int
    {
        return count($this->items);
    }

    public function lastPage(): int
    {
        return 1;
    }

    public function firstPage(): ?int
    {
        return 1;
    }

    public function totalPerPage(): int
    {
        return 15;
    }

    public function nextPage(): ?int
    {
        return 1;
    }

    public function previousPage(): ?int
    {
        return 1;
    }

    public function currentPage(): int
    {
        return 1;
    }
}

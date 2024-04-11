<?php

namespace App\Adapters;

use Core\Plan\Domain\Repositories\PaginationInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationEloquentAdapter extends LengthAwarePaginator implements PaginationInterface
{
    public function __construct(private LengthAwarePaginator $paginator)
    {
    }

    /**
     * @return array<stdClass>
     */
    public function items(): array
    {
        return $this->paginator->items();
    }

    public function total(): int
    {
        return (int) $this->paginator->total();
    }

    public function lastPage(): int
    {
        return (int) $this->paginator->lastPage();
    }

    public function firstPage(): int
    {
        return (int) $this->paginator->firstPage();
    }

    public function totalPerPage(): int
    {
        return (int) $this->paginator->totalPerPage();
    }

    public function nextPage(): int
    {
        return (int) $this->paginator->nextPage();
    }

    public function previousPage(): int
    {
        return (int) $this->paginator->previousPage();
    }
}

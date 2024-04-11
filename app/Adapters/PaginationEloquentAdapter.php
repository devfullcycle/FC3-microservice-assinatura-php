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

    public function firstPage(): ?int
    {
        return $this->paginator->firstItem();
    }

    public function totalPerPage(): int
    {
        return (int) $this->paginator->perPage();
    }

    public function nextPage(): ?int
    {
        if (!$this->paginator->hasMorePages()) {
            return null;
        }
        return (int) $this->paginator->currentPage() + 1;
    }

    public function previousPage(): ?int
    {
        if ($this->paginator->currentPage() === 1) {
            return null;
        }

        return (int) $this->paginator->current() - 1;
    }
}

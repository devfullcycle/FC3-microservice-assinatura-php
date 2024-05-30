<?php

namespace App\Repositories\Eloquent;

use App\Adapters\PaginationEloquentAdapter;
use App\Models\PlanCost as Model;
use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\Repositories\PaginationInterface;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class PlanCostRepository implements PlanCostRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function insert(PlanCost $planCost): PlanCost
    {
        $model = $this->model->create([
            'id' => (string) $planCost->id(),
            'price' => $planCost->name,
            'recurrence_period' => $planCost->recurrencePeriod->value,
        ]);

        return $this->convertModelToEntity($model);
    }

    public function findById(string $id): PlanCost
    {
        if (! $model = $this->model->find($id)) {
            throw new EntityNotFoundException('PlanCost not found');
        }

        return $this->convertModelToEntity($model);
    }

    /**
     * @return PlanCost[]
     */
    public function findAll(string $filter = '', string $orderBy = 'DESC'): array
    {
        $response = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter !== '') {
                    $query->where('price', $filter);
                }
            })
            ->orderBy('recurrence_period', $orderBy)
            ->get();

        return $response->map(fn (Model $model) => $this->convertModelToEntity($model))->toArray();
    }

    public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface
    {
        $results = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter !== '') {
                    $query->whereName($filter);
                }
            })
            ->orderBy('recurrence_period', $orderBy)
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationEloquentAdapter($results);
    }

    public function update(PlanCost $planCost): ?PlanCost
    {
        if (! $model = $this->model->find($planCost->id())) {
            throw new EntityNotFoundException('PlanCost not found');
        }
        $model->update([
            'price' => $planCost->price,
        ]);

        return $this->convertModelToEntity($model);
    }

    public function delete(string $id): bool
    {
        if (! $model = $this->model->find($id)) {
            throw new EntityNotFoundException('PlanCost not found');
        }

        return $model->delete();
    }

    private function convertModelToEntity(Model $model): PlanCost
    {
        return new PlanCost(
            id: new Uuid($model->id),
            price: $model->price,
            recurrencePeriod: RecurrencePeriodEnum::from($model->recurrence_period),
        );
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Adapters\PaginationEloquentAdapter;
use App\Models\Plan as Model;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\Repositories\PaginationInterface;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class PlanRepository implements PlanRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function insert(Plan $plan): Plan
    {
        $model = $this->model->create([
            'id' => (string) $plan->id(),
            'name' => $plan->name,
            'description' => $plan->description,
        ]);

        return $this->convertModelToEntity($model);
    }

    public function findById(string $id): Plan
    {
        if (! $model = $this->model->find($id)) {
            throw new EntityNotFoundException('Plan not found');
        }

        return $this->convertModelToEntity($model);
    }

    /**
     * @return Plan[]
     */
    public function findAll(string $filter = '', string $orderBy = 'DESC'): array
    {
        $response = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter !== '') {
                    $query->where('name', $filter);
                    $query->orWhere('description', 'like', "%{$filter}%");
                }
            })
            ->orderBy('name', $orderBy)
            ->get();

        return $response->map(fn (Model $model) => $this->convertModelToEntity($model))->toArray();
    }

    public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface
    {
        $results = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter !== '') {
                    $query->whereName($filter);
                    $query->orWhere('description', 'like', "%{$filter}%");
                }
            })
            ->orderBy('name', $orderBy)
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationEloquentAdapter($results);
    }

    public function update(Plan $plan): ?Plan
    {
        if (! $model = $this->model->find($plan->id())) {
            return null;
        }
        $model->update([
            'name' => $plan->name,
            'description' => $plan->description,
        ]);

        return $this->convertModelToEntity($model);
    }

    public function delete(string $id): bool
    {
        if (! $model = $this->model->find($id)) {
            return false;
        }
        $model->delete();

        return true;
    }

    private function convertModelToEntity(Model $model): Plan
    {
        return new Plan(
            id: new Uuid($model->id),
            name: $model->name,
            description: $model->description
        );
    }
}

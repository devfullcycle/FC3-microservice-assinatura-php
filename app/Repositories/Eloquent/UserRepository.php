<?php

namespace App\Repositories\Eloquent;

use App\Adapters\PaginationEloquentAdapter;
use App\Models\User as Model;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\Repositories\PaginationInterface;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function insert(User $user): User
    {
        $model = $this->model->create([
            'id' => (string) $user->id(),
            'name' => $user->name,
            'description' => $user->description,
        ]);

        return $this->convertModelToEntity($model);
    }

    public function findById(string $id): User
    {
        if (! $model = $this->model->find($id)) {
            throw new EntityNotFoundException('User not found');
        }

        return $this->convertModelToEntity($model);
    }

    /**
     * @return User[]
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

    public function update(User $user): ?User
    {
        if (! $model = $this->model->find($user->id())) {
            return null;
        }
        $model->update([
            'name' => $user->name,
            'description' => $user->description,
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

    private function convertModelToEntity(Model $model): User
    {
        return new User(
            id: new Uuid($model->id),
            name: $model->name,
            description: $model->description
        );
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Adapters\PaginationEloquentAdapter;
use App\Models\User as Model;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\Repositories\PaginationInterface;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function insert(User $user): User
    {
        $modelUser = $this->model->create([
            'id' => (string) $user->id(),
            'name' => $user->name,
            'last_name' => $user->lastName,
            'age' => $user->age,
            'type' => $user->type instanceof CpfVO ? 'cpf' : 'cnpj',
            'document' => (string) $user->type,
        ]);
        $modelUser->address()->create([
            'city' => $user->address->city,
            'state' => $user->address->state,
            'country' => $user->address->country,
            'zip_code' => $user->address->zipCode,
            'number' => $user->address->number,
            'street' => $user->address->street,
        ]);

        return $this->convertModelToEntity($modelUser);
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
                }
            })
            ->orderBy('name', $orderBy)
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationEloquentAdapter($results);
    }

    public function update(User $user): ?User
    {
        if (! $model = $this->model->find($user->id())) {
            throw new EntityNotFoundException('User not found');
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
            throw new EntityNotFoundException('User not found');
        }
        $model->delete();

        return true;
    }

    private function convertModelToEntity(Model $model): User
    {
        return new User(
            id: new Uuid($model->id),
            name: $model->name,
            lastName: $model->last_name,
            age: $model->age,
            address: new Address(
                street: $model->address->street,
                city: $model->address->city,
                state: $model->address->state,
                country: $model->address->country,
                zipCode: $model->address->zip_code,
                number: $model->address->number
            ),
            type: $model->type === 'cpf' ? new CpfVO($model->document) : new CnpjVO($model->document),
        );
    }
}

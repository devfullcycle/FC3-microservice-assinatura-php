<?php

namespace App\Repositories\Eloquent;

use Core\SeedWork\Domain\ValueObjects\Uuid;
use App\Models\UserSubscription as Model;
use Core\Plan\Domain\Entities\Plan;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\User\Domain\Entities\User;
use Core\UserSubscription\Domain\Entities\UserSubscription;
use Core\UserSubscription\Domain\Repositories\UserSubscriptionRepositoryInterface;
use DateTime;

class UserSubscriptionRepository implements UserSubscriptionRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function save(UserSubscription $userSubscription): UserSubscription
    {
        $dataDb = $this->model->create([
            'id' => (string) $userSubscription->id(),
            'user_id' => (string) $userSubscription->user->id(),
            'plan_id' => (string) $userSubscription->plan->id(),
            'ends_at' => $userSubscription->endsAt->format('Y-m-d'),
            'last_billing' => $userSubscription->lastBilling->format('Y-m-d'),
            'active' => $userSubscription->active,
            'canceled' => $userSubscription->cancelled,
        ]);
        $dataDb->load(['user.address', 'plan']);

        return $this->convertModelToEntity($dataDb);
    }

    public function getByID(string $id): UserSubscription
    {
        if (! $dataDb = $this->model->find($id)) {
            throw new EntityNotFoundException('User subscription not found');
        }

        return $this->convertModelToEntity($dataDb);
    }

    public function getByUserId(string $userId): UserSubscription
    {
        if (! $dataDb = $this->model->where('user_id', $userId)->first()) {
            throw new EntityNotFoundException('User subscription not found');
        }

        return $this->convertModelToEntity($dataDb);
    }

    private function convertModelToEntity(Model $model): UserSubscription
    {
        $address = new Address(
            street: $model->user->address->street,
            city: $model->user->address->city,
            state: $model->user->address->state,
            country: $model->user->address->country,
            zipCode: $model->user->address->zip_code,
            number: $model->user->address->number
        );
        
        $user = new User(
            id: new Uuid($model->user->id),
            lastName: $model->user->last_name,
            name: $model->user->name,
            age: $model->user->age,
            address: $address,
            type: $model->user->type === 'cpf' ? new CpfVO($model->user->document) : new CnpjVO($model->user->document),
        );
        
        $plan = new Plan(
            id: new Uuid($model->plan->id),
            name: $model->plan->name,
            description: $model->plan->description,
        );
        
        return new UserSubscription(
            id: new Uuid($model->id),
            user: $user,
            plan: $plan,
            endsAt: new DateTime($model->ends_at),
            lastBilling: new DateTime($model->last_billing),
            active: $model->active,
            cancelled: $model->canceled,
        );
    }
}
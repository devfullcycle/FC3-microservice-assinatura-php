<?php

namespace App\Repositories\Eloquent;

use App\Models\SubscriptionTransaction as Model;
use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\SubscriptionTransaction\Domain\Entities\SubscriptionTransaction;
use Core\SubscriptionTransaction\Domain\Repositories\SubscriptionTransactionInterface;
use Core\User\Domain\Entities\User;
use DateTime;

class SubscriptionTransactionRepository implements SubscriptionTransactionInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function create(SubscriptionTransaction $subscriptionTransaction): SubscriptionTransaction
    {
        $dataDb = $this->model->create([
            'id' => (string) $subscriptionTransaction->id(),
            'user_id' => (string) $subscriptionTransaction->user->id(),
            'plan_cost_id' => (string) $subscriptionTransaction->plan->id(),
            'date_payment' => $subscriptionTransaction->datePayment->format('Y-m-d'),
            'amount' => $subscriptionTransaction->amount,
        ]);
        $dataDb->load(['user.address', 'planCost']);

        return $this->convertModelToEntity($dataDb);
    }

    private function convertModelToEntity(Model $model): SubscriptionTransaction
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

        $planCost = new PlanCost(
            id: new Uuid($model->planCost->id),
            price: $model->planCost->price,
            recurrencePeriod: RecurrencePeriodEnum::from($model->planCost->recurrence_period),
        );

        return new SubscriptionTransaction(
            id: new Uuid($model->id),
            user: $user,
            plan: $planCost,
            datePayment: new DateTime($model->date_payment),
            amount: $model->amount,
        );
    }
}

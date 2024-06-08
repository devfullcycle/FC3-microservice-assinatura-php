<?php

use App\Models\Address as AddressModel;
use App\Models\PlanCost as PlanCostModel;
use App\Models\User as UserModel;
use Core\SubscriptionTransaction\Application\DTO\CreateSubscriptionTransactionDTO;
use Core\SubscriptionTransaction\Application\DTO\OutputSubscriptionDTO;
use Core\SubscriptionTransaction\Application\UseCase\CreateSubscriptionTransaction;

use function Pest\Laravel\assertDatabaseHas;

test('should create new subscription transaction', function () {
    $useCase = app(CreateSubscriptionTransaction::class);
    $user = UserModel::factory()->create(['type' => 'cpf']);
    AddressModel::factory()->create(['user_id' => $user->id]);
    $planCost = PlanCostModel::factory()->create();

    $response = $useCase->execute(new CreateSubscriptionTransactionDTO(
        userId: $user->id,
        planCostId: $planCost->id,
        datePayment: '2029-01-01',
        amount: 1.00
    ));

    expect($response)->toBeInstanceOf(OutputSubscriptionDTO::class);
    expect($response->user->name)->toBe($user->name);
    expect($response->planCost->price)->toBe($planCost->price);
    expect($response->date_payment)->toBe('2029-01-01 00:00:00');
    expect($response->amount)->toBe(1.00);
    assertDatabaseHas('subscription_transactions', [
        'user_id' => $user->id,
        'plan_cost_id' => $planCost->id,
    ]);
});

<?php

use App\Models\Address as AddressModel;
use App\Models\Plan as PlanModel;
use App\Models\User as UserModel;
use Core\UserSubscription\Application\DTO\CreateUserSubscriptionDTO;
use Core\UserSubscription\Application\DTO\OutputUserSubscription;
use Core\UserSubscription\Application\UseCase\CreateUserSubscription;

use function Pest\Laravel\assertDatabaseHas;

test('should create new user subscription', function () {
    $useCase = app(CreateUserSubscription::class);
    $user = UserModel::factory()->create(['type' => 'cpf']);
    AddressModel::factory()->create(['user_id' => $user->id]);
    $plan = PlanModel::factory()->create();

    $response = $useCase->execute(new CreateUserSubscriptionDTO(
        userId: $user->id,
        planId: $plan->id,
        endsAt: '2029-01-01',
        lastBilling: '2029-01-01',
        active: true,
        cancelled: false
    ));

    expect($response)->toBeInstanceOf(OutputUserSubscription::class);
    expect($response->user->name)->toBe($user->name);
    expect($response->plan->name)->toBe($plan->name);
    expect($response->last_billing)->toBe('2029-01-01 00:00:00');
    expect($response->ends_at)->toBe('2029-01-01 00:00:00');
    expect($response->id)->not->toBeNull();
    assertDatabaseHas('user_subscriptions', [
        'user_id' => $user->id,
        'plan_id' => $plan->id,
    ]);
});

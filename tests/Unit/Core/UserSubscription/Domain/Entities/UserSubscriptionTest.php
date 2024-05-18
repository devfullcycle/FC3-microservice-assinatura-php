<?php

use Core\Plan\Domain\Entities\Plan;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\User\Domain\Entities\User;
use Core\UserSubscription\Domain\Entities\UserSubscription;

test('should be able to create user subscription', function () {
    $cpfVo = new CpfVO('937.941.550-84');
    $address = new Address(
        street: 'street',
        city: 'city',
        state: 'state',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );
    $user = new User(name: 'John', lastName: 'Doe', age: 31, address: $address, type: $cpfVo);
    $plan = new Plan(name: 'Basic', description: 'Basic plan');
    $subscription = new UserSubscription(
        user: $user,
        plan: $plan,
        endsAt: new DateTime('12-12-2000'),
        lastBilling: new DateTime('12-12-2000'),
        active: true,
        cancelled: false,
    );
    expect(true)->toBeTrue();
})->only();

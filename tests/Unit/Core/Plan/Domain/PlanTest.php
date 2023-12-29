<?php

use Core\Plan\Domain\Plan;
use Core\SeedWork\Domain\ValueObjects\Uuid;

it('should access all properties', function () {
    $plan = new Plan(
        name: 'plan name',
        description: 'desc plan'
    );
    expect($plan->name)->toBe('plan name');
    expect($plan->description)->toBe('desc plan');

    expect($plan->id)->not->toBeNull();
    expect($plan->id())->toBeString();
    expect($plan->name)->toBeString();
    expect($plan->description)->toBeString();
});

it('should use uuid passed', function () {
    $id = Uuid::random();
    $plan = new Plan(
        id: $id,
        name: 'plan name',
        description: 'desc plan'
    );
    expect($plan->id)->toBe($id);
    expect($plan->id())->toBe((string) $id);
});

<?php

use Core\Plan\Domain\Plan;

it('should access all properties', function () {
    $plan = new Plan(
        id: 'uuid-value',
        name: 'plan name',
        description: 'desc plan'
    );
    expect($plan->id)->toBe('uuid-value');
    expect($plan->id())->toBe('uuid-value');
    expect($plan->name)->toBe('plan name');
    expect($plan->description)->toBe('desc plan');

    expect($plan->id)->toBeString();
    expect($plan->id())->toBeString();
    expect($plan->name)->toBeString();
    expect($plan->description)->toBeString();
});

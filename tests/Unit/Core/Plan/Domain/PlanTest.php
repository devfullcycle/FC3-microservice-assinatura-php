<?php

use Core\Plan\Domain\Plan;
use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Faker\Factory;

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

it('should throws exceptions when name is wrong - less 2', function () {
    new Plan(
        name: 'a',
        description: 'desc test',
    );
})->throws(EntityValidationException::class, 'The value must be at least 3 characters');

it('should throws exceptions when name is wrong - more 255', function () {
    $name = Factory::create()->sentence(255);
    new Plan(
        name: $name,
        description: 'desc test',
    );
})->throws(EntityValidationException::class, 'The value must not be greater than 255 characters');

it('should throws exceptions when description is wrong - less 10', function () {
    new Plan(
        name: 'plan platinum',
        description: 'desc',
    );
})->throws(EntityValidationException::class, 'The value must be at least 5 characters');

it('should throws exceptions when description is wrong - more 10000', function () {
    $description = Factory::create()->sentence(10000);
    new Plan(
        name: 'plan premium',
        description: $description,
    );
})->throws(EntityValidationException::class, 'The value must not be greater than 10000 characters');

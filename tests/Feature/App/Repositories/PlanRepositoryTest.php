<?php

use App\Models\Plan as Model;
use App\Repositories\Eloquent\PlanRepository;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

use function Pest\Laravel\assertDatabaseHas;

test('should insert plan in database', function () {
    $repository = new PlanRepository(new Model);

    $plan = new Plan(
        name: 'plan test',
        description: 'description test'
    );
    $entity = $repository->insert($plan);

    expect($repository)->toBeInstanceOf(PlanRepositoryInterface::class);
    assertDatabaseHas('plans', [
        'id' => $plan->id,
        'name' => $plan->name,
        'description' => $plan->description,
    ]);
    expect($plan->id())->toBe($entity->id());
    expect($plan->name)->toBe($entity->name);
    expect($plan->description)->toBe($entity->description);
});

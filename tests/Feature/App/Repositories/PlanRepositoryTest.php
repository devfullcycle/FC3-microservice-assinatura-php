<?php

use App\Models\Plan as Model;
use App\Repositories\Eloquent\PlanRepository;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => $this->repository = new PlanRepository(new Model));

test('should insert plan in database', function () {
    $plan = new Plan(
        name: 'plan test',
        description: 'description test'
    );
    $entity = $this->repository->insert($plan);

    expect($this->repository)->toBeInstanceOf(PlanRepositoryInterface::class);
    assertDatabaseHas('plans', [
        'id' => $plan->id,
        'name' => $plan->name,
        'description' => $plan->description,
    ]);
    expect($plan->id())->toBe($entity->id());
    expect($plan->name)->toBe($entity->name);
    expect($plan->description)->toBe($entity->description);
});

test('should throws exception when not found plan', function () {
    $this->repository->findById('fake');
})->throws(EntityNotFoundException::class, 'Plan not found');

test('should return entity', function () {
    $planFactory = Model::factory()->create();
    $entity = $this->repository->findById($planFactory->id);

    expect($entity->id())->toBe($planFactory->id);
    expect($entity->name)->toBe($planFactory->name);
    expect($entity->description)->toBe($planFactory->description);
});

test('should return empty array when not exists plans', function () {
    $entities = $this->repository->findAll();
    expect($entities)->toBe([]);
});

test('should return array of entity plan', function () {
    Model::factory()->count(10)->create();
    $entities = $this->repository->findAll();
    expect(count($entities))->toBe(10);
});

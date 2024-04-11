<?php

use App\Models\Plan as Model;
use App\Repositories\Eloquent\PlanRepository;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\ValueObjects\Uuid;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

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
    array_map(fn (Plan $plan) => expect($plan)->toBeInstanceOf(Plan::class), $entities);
});

test('should return array of entity plan - with filter', function () {
    Model::factory()->count(10)->create();
    Model::factory()->count(10)->create(['name' => 'plan test filter']);
    $entities = $this->repository->findAll(
        filter: 'plan test filter'
    );
    expect(count($entities))->toBe(10);
    array_map(fn (Plan $plan) => expect($plan)->toBeInstanceOf(Plan::class), $entities);
});

test('should return false when try remove plan not found', function () {
    expect($this->repository->delete('fake'))->toBeFalse();
});

test('should return true when remove plan', function () {
    $model = Model::factory()->create();

    expect($this->repository->delete($model->id))->toBeTrue();
    assertDatabaseMissing('plans', ['id' => $model->id]);
});

test('should return null when not found plan', function () {
    $plan = new Plan('name', 'description');
    expect($this->repository->update($plan))->toBeNull();
});

test('should update plan', function () {
    $model = Model::factory()->create();
    $plan = new Plan(
        id: new Uuid($model->id),
        name: 'new name',
        description: 'new description'
    );
    $entity = $this->repository->update($plan);

    expect($entity->name)->toBe($entity->name);
    expect($entity->description)->toBe($entity->description);
    assertDatabaseHas('plans', [
        'id' => $model->id,
        'name' => $plan->name,
        'description' => $plan->description,
    ]);
});

test('should return empty array when not exists plans - paginate', function () {
    $pagination = $this->repository->paginate();
    expect($pagination->items())->toBe([]);
    expect($pagination->firstPage())->toBe(null);
});

test('should return plans with paginate', function () {
    Model::factory()->count(100)->create();

    $pagination = $this->repository->paginate();

    expect(count($pagination->items()))->toBe(15);
    expect($pagination->total())->toBe(100);
    expect($pagination->lastPage())->toBe(7);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(15);
    expect($pagination->nextPage())->toBe(2);
    expect($pagination->previousPage())->toBe(null);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());
});

test('should paginate with total 10 items per page', function () {
    Model::factory()->count(100)->create();

    $pagination = $this->repository->paginate(totalPerPage: 10);

    expect(count($pagination->items()))->toBe(10);
    expect($pagination->total())->toBe(100);
    expect($pagination->lastPage())->toBe(10);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(10);
    expect($pagination->nextPage())->toBe(2);
    expect($pagination->previousPage())->toBe(null);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());
});

test('should paginate with filter', function () {
    Model::factory()->count(50)->create();
    Model::factory()->count(50)->create(['name' => 'plan filter']);

    $pagination = $this->repository->paginate(filter: 'plan filter');

    expect(count($pagination->items()))->toBe(15);
    expect($pagination->total())->toBe(50);
    expect($pagination->lastPage())->toBe(4);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(15);
    expect($pagination->nextPage())->toBe(2);
    expect($pagination->previousPage())->toBe(null);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());

    $pagination = $this->repository->paginate(filter: 'plan filter', totalPerPage: 10);

    expect(count($pagination->items()))->toBe(10);
    expect($pagination->total())->toBe(50);
    expect($pagination->lastPage())->toBe(5);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(10);
    expect($pagination->nextPage())->toBe(2);
    expect($pagination->previousPage())->toBe(null);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());
});

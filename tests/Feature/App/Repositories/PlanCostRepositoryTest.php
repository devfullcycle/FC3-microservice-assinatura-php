<?php

use App\Models\PlanCost as Model;
use App\Repositories\Eloquent\PlanCostRepository;
use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;
use Core\SeedWork\Domain\ValueObjects\Uuid;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(fn () => $this->repository = new PlanCostRepository(new Model));

test('should insert planCost in database', function () {
    $planCost = new PlanCost(
        price: 1.00,
        recurrencePeriod: RecurrencePeriodEnum::MONTHLY
    );
    $entity = $this->repository->insert($planCost);

    expect($this->repository)->toBeInstanceOf(PlanCostRepositoryInterface::class);
    assertDatabaseHas('plan_costs', [
        'id' => $planCost->id,
        'price' => $planCost->price,
        'recurrence_period' => $planCost->recurrencePeriod->value,
    ]);
    expect($planCost->id())->toBe($entity->id());
    expect($planCost->price)->toBe($entity->price);
});

test('should throws exception when not found planCost', function () {
    $this->repository->findById('fake');
})->throws(EntityNotFoundException::class, 'PlanCost not found');

test('should return entity', function () {
    $planCostFactory = Model::factory()->create();
    $entity = $this->repository->findById($planCostFactory->id);

    expect($entity->id())->toBe($planCostFactory->id);
    expect($entity->price)->toBe($planCostFactory->price);
});

test('should return empty array when not exists planCosts', function () {
    $entities = $this->repository->findAll();
    expect($entities)->toBe([]);
});

test('should return array of entity planCost', function () {
    Model::factory()->count(10)->create(['price' => 1.00]);
    $entities = $this->repository->findAll();
    expect(count($entities))->toBe(10);
    array_map(fn (PlanCost $planCost) => expect($planCost)->toBeInstanceOf(PlanCost::class), $entities);
});

test('should throws exception when try remove planCost not found', function () {
    $this->repository->delete('fake');
})->throws(EntityNotFoundException::class, 'PlanCost not found');

test('should return true when remove planCost', function () {
    $model = Model::factory()->create();

    expect($this->repository->delete($model->id))->toBeTrue();
    assertDatabaseMissing('plan_costs', ['id' => $model->id]);
});

test('should throws exception when not found planCost - update', function () {
    $planCost = new PlanCost(1.00, RecurrencePeriodEnum::MONTHLY);
    expect($this->repository->update($planCost))->toBeNull();
})->throws(EntityNotFoundException::class, 'PlanCost not found');

test('should update planCost', function () {
    $model = Model::factory()->create();
    $planCost = new PlanCost(
        id: new Uuid($model->id),
        price: 2.00,
        recurrencePeriod: RecurrencePeriodEnum::MONTHLY
    );
    $entity = $this->repository->update($planCost);

    expect($entity->price)->toBe($entity->price);
    assertDatabaseHas('plan_costs', [
        'id' => $model->id,
        'price' => $planCost->price,
    ]);
});

test('should return empty array when not exists planCosts - paginate', function () {
    $pagination = $this->repository->paginate();
    expect($pagination->items())->toBe([]);
    expect($pagination->firstPage())->toBe(null);
});

test('should return planCosts with paginate', function () {
    Model::factory()->count(100)->create();

    $pagination = $this->repository->paginate();

    expect(count($pagination->items()))->toBe(15);
    expect($pagination->total())->toBe(100);
    expect($pagination->lastPage())->toBe(7);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(15);
    expect($pagination->nextPage())->toBe(2);
    expect($pagination->previousPage())->toBe(null);
    expect($pagination->currentPage())->toBe(1);
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
    expect($pagination->currentPage())->toBe(1);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());
});

test('should paginate with custom page', function () {
    Model::factory()->count(100)->create();

    $pagination = $this->repository->paginate(page: 2);

    expect(count($pagination->items()))->toBe(15);
    expect($pagination->total())->toBe(100);
    expect($pagination->lastPage())->toBe(7);
    expect($pagination->firstPage())->toBe(1);
    expect($pagination->totalPerPage())->toBe(15);
    expect($pagination->nextPage())->toBe(3);
    expect($pagination->previousPage())->toBe(1);
    expect($pagination->currentPage())->toBe(2);
    array_map(fn ($entity) => expect($entity)->toBeInstanceOf(stdClass::class), $pagination->items());
});

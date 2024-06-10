<?php

use App\Models\Plan;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('should get all plans - with empty plans', function () {
    getJson(route('plans.index'))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [],
            'meta' => [
                'total',
                'last_page',
                'first_page',
                'next_page',
                'previous_page',
            ],
        ]);
});

test('should get paginate plans', function () {
    Plan::factory(20)->create();
    getJson(route('plans.index'))
        ->assertStatus(200)
        ->assertJsonCount(15, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                ],
            ],
            'meta' => [
                'total',
                'last_page',
                'first_page',
                'next_page',
                'previous_page',
            ],
        ]);
});

test('should get paginate plans - page 2', function () {
    Plan::factory(20)->create();
    getJson(route('plans.index') . '?page=2')
        ->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                ],
            ],
            'meta' => [
                'total',
                'last_page',
                'first_page',
                'next_page',
                'previous_page',
            ],
        ]);
});

test('should get paginate plans - total per page', function () {
    Plan::factory(20)->create();
    getJson(route('plans.index') . '?per_page=20')
        ->assertOk()
        ->assertJsonCount(20, 'data');
});

test('should get paginate plans - with filter', function () {
    Plan::factory(10)->create();
    Plan::factory(10)->create(['name' => 'custom']);
    getJson(route('plans.index') . '?filter=custom')
        ->assertOk()
        ->assertJsonCount(10, 'data');
});

test('should create new plan', function () {
    postJson(
        uri: route('plans.store'),
        data: [
            'name' => 'test name',
            'description' => 'test description',
        ],
        headers: ['Accept' => 'application/json']
    )->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
            ]
        ]);
});

describe('validations', function () {
    test('should validate create plan', function () {
        postJson(
            uri: route('plans.store'),
            data: [],
            headers: ['Accept' => 'application/json']
        )->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'description',
            ]);
    });
});

test('should return plan by id', function () {
    $plan = Plan::factory()->create();
    getJson(route('plans.show', $plan->id))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
            ],
        ]);
});

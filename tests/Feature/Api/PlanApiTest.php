<?php

use App\Models\Plan;

use function Pest\Laravel\getJson;

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

test('should get all plans', function () {
    Plan::factory(10)->create();
    getJson(route('plans.index'))
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
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

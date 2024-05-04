<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\InputPlansDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Application\DTO\OutputPlansDTO;
use Core\Plan\Application\UseCase\GetPlansUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

beforeEach(fn () => $this->useCase = new GetPlansUseCase(app(PlanRepositoryInterface::class)));

test('should get plans with paginate', function () {
    Model::factory()->count(50)->create();

    $response = $this->useCase->execute(new InputPlansDTO());

    expect($response)->toBeInstanceOf(OutputPlansDTO::class);
    expect(count($response->items))->toBe(15);
    expect($response->total)->toBe(50);
    expect($response->last_page)->toBe(4);
    expect($response->first_page)->toBe(1);
    expect($response->next_page)->toBe(2);
    expect($response->previous_page)->toBeNull();
    array_map(fn ($dtoOutput) => expect($dtoOutput)->toBeInstanceOf(OutputPlanDTO::class), $response->items);
});

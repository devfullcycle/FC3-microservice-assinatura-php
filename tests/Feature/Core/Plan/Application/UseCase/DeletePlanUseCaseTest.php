<?php

use App\Models\Plan as Model;
use Core\Plan\Application\DTO\DeleteOutputPlanDTO;
use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\UseCase\DeletePlanUseCase;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

use function Pest\Laravel\assertDatabaseMissing;

beforeEach(fn () => $this->useCase = new DeletePlanUseCase(app(PlanRepositoryInterface::class)));

test('should delete plan', function () {
    $model = Model::factory()->create();

    $response = $this->useCase->execute(new InputPlanDTO(id: $model->id));

    expect($response)->toBeInstanceOf(DeleteOutputPlanDTO::class);
    expect($response->deleted)->toBeTrue();
    assertDatabaseMissing('plans', ['id' => $model->id]);
});

test('should throws exception when plan not found', function () {
    $this->useCase->execute(new InputPlanDTO(id: 'fake_id'));
})->throws(EntityNotFoundException::class);

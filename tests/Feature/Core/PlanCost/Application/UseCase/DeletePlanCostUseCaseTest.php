<?php

use App\Models\PlanCost as Model;
use Core\PlanCost\Application\DTO\DeleteOutputPlanCostDTO;
use Core\PlanCost\Application\DTO\InputPlanCostDTO;
use Core\PlanCost\Application\UseCase\DeletePlanCostUseCase;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SeedWork\Domain\Exceptions\EntityNotFoundException;

use function Pest\Laravel\assertDatabaseMissing;

beforeEach(fn () => $this->useCase = new DeletePlanCostUseCase(app(PlanCostRepositoryInterface::class)));

test('should delete planCost', function () {
    $model = Model::factory()->create();

    $response = $this->useCase->execute(new InputPlanCostDTO(id: $model->id));

    expect($response)->toBeInstanceOf(DeleteOutputPlanCostDTO::class);
    expect($response->deleted)->toBeTrue();
    assertDatabaseMissing('plan_costs', ['id' => $model->id]);
});

test('should throws exception when planCost not found', function () {
    $this->useCase->execute(new InputPlanCostDTO(id: 'fake_id'));
})->throws(EntityNotFoundException::class);

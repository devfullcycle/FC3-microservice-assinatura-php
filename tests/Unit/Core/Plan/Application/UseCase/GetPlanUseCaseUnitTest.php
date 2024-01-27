<?php

use Core\Plan\Application\UseCase\GetPlanUseCase;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PaginationInterface;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

test('should return plan', function () {
    class anonymous implements PlanRepositoryInterface {
        public function insert(Plan $plan): Plan
        {
            throw new \Exception('Not implemented');
        }

        public function findById(string $id): Plan
        {
            throw new \Exception('Not implemented');
        }

        /**
         * @return stdClass[]
         */
        public function findAll(string $filter = '', string $orderBy = 'DESC'): array
        {
            throw new \Exception('Not implemented');
        }

        public function paginate(string $filter = '', string $orderBy = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface
        {
            throw new \Exception('Not implemented');
        }

        public function update(Plan $plan): Plan
        {
            throw new \Exception('Not implemented');
        }

        public function delete(string $id): bool
        {
            throw new \Exception('Not implemented');
        }
    }
    $useCase = new GetPlanUseCase(
        repository: new anonymous()
    );
});

<?php

namespace Core\SubscriptionTransaction\Application\UseCase;

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SubscriptionTransaction\Application\DTO\CreateSubscriptionTransactionDTO;
use Core\SubscriptionTransaction\Application\DTO\OutputSubscriptionDTO;
use Core\SubscriptionTransaction\Domain\Entities\SubscriptionTransaction;
use Core\SubscriptionTransaction\Domain\Repositories\SubscriptionTransactionInterface;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use DateTime;

class CreateSubscriptionTransaction
{

    public function __construct(
        private SubscriptionTransactionInterface $repository,
        private UserRepositoryInterface $userRepository,
        private PlanCostRepositoryInterface $planCostRepository
    ) {
    }

    public function execute(CreateSubscriptionTransactionDTO $input): OutputSubscriptionDTO
    {
        $entity = $this->repository->create($this->createEntitySubscriptionTransaction($input));

        return OutputSubscriptionDTO::fromEntity($entity);
    }

    private function createEntitySubscriptionTransaction(CreateSubscriptionTransactionDTO $input): SubscriptionTransaction
    {
        $user = $this->getUserEntity($input->userId);
        $planCost = $this->getPlanCostEntity($input->planCostId);

        return new SubscriptionTransaction(
            user: $user,
            plan: $planCost,
            datePayment: new DateTime($input->datePayment),
            amount: $input->amount
        );
    }

    private function getUserEntity(string $id): User
    {
        return $this->userRepository->findById($id);
    }

    private function getPlanCostEntity(string $id): PlanCost
    {
        return $this->planCostRepository->findById($id);
    }
}
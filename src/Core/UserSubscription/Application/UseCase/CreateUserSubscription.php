<?php

namespace Core\UserSubscription\Application\UseCase;

use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Core\UserSubscription\Application\DTO\CreateUserSubscriptionDTO;
use Core\UserSubscription\Application\DTO\OutputUserSubscription;
use Core\UserSubscription\Domain\Entities\UserSubscription;
use Core\UserSubscription\Domain\Repositories\UserSubscriptionRepositoryInterface;
use DateTime;

class CreateUserSubscription
{
    public function __construct(
        private UserSubscriptionRepositoryInterface $subscriptionRepository,
        private UserRepositoryInterface $userRepository,
        private PlanRepositoryInterface $planRepository,
    ) {
    }

    public function execute(CreateUserSubscriptionDTO $input): OutputUserSubscription
    {
        $userSubscription = $this->subscriptionRepository->save(new UserSubscription(
            user: $this->getUserEntity($input->userId),
            plan: $this->getPlanEntity($input->planId),
            endsAt: new DateTime($input->endsAt),
            lastBilling: new DateTime($input->lastBilling),
            active: true,
            cancelled: false,
        ));

        return OutputUserSubscription::fromEntity($userSubscription);
    }

    private function getUserEntity(string $id): User
    {
        return $this->userRepository->findById($id);
    }

    private function getPlanEntity(string $id): Plan
    {
        return $this->planRepository->findById($id);
    }
}

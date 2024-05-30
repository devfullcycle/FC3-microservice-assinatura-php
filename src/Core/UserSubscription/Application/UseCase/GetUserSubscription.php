<?php

namespace Core\UserSubscription\Application\UseCase;

use Core\Plan\Application\DTO\GetByUserSubscriptionDTO;
use Core\Plan\Application\DTO\OutputUserSubscription;
use Core\UserSubscription\Domain\Repositories\UserSubscriptionRepositoryInterface;

class GetUserSubscription
{
    public function __construct(
        private UserSubscriptionRepositoryInterface $subscriptionRepository,
    ) {
    }

    public function execute(GetByUserSubscriptionDTO $input): OutputUserSubscription
    {
        $userSubscription = $this->subscriptionRepository->getByUserId($input->userId);

        return OutputUserSubscription::fromEntity($userSubscription);
    }
}

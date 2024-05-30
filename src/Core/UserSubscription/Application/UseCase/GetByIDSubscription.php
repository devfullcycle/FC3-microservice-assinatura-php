<?php

namespace Core\UserSubscription\Application\UseCase;

use Core\Plan\Application\DTO\GetByIDSubscriptionDTO;
use Core\Plan\Application\DTO\OutputUserSubscription;
use Core\UserSubscription\Domain\Repositories\UserSubscriptionRepositoryInterface;

class GetByIDSubscription
{
    public function __construct(
        private UserSubscriptionRepositoryInterface $subscriptionRepository,
    ) {
    }

    public function execute(GetByIDSubscriptionDTO $input): OutputUserSubscription
    {
        $userSubscription = $this->subscriptionRepository->getByID($input->id);

        return OutputUserSubscription::fromEntity($userSubscription);
    }
}

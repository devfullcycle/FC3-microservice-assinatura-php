<?php

namespace Core\UserSubscription\Domain\Repositories;

use Core\UserSubscription\Domain\Entities\UserSubscription;

interface UserSubscriptionRepositoryInterface
{
    public function save(UserSubscription $userSubscription): UserSubscription;

    public function getByID(string $id): UserSubscription;

    public function getByUserId(string $userId): UserSubscription;
}

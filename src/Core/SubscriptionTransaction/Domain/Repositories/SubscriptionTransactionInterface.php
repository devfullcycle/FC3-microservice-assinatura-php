<?php

namespace Core\SubscriptionTransaction\Domain\Repositories;

use Core\SubscriptionTransaction\Domain\Entities\SubscriptionTransaction;

interface SubscriptionTransactionInterface
{
    public function create(SubscriptionTransaction $subscriptionTransaction): SubscriptionTransaction;
}

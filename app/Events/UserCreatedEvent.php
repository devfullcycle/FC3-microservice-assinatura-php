<?php

namespace App\Events;

use Core\SeedWork\Domain\Events\EventDomainInterface;
use Core\User\Application\Interfaces\UserCreatedEventInterface;

class UserCreatedEvent implements UserCreatedEventInterface
{
    public function dispatch(EventDomainInterface $event): void
    {
        event($event);
    }
}

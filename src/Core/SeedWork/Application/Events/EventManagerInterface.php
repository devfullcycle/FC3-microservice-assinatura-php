<?php

namespace Core\SeedWork\Application\Events;

use Core\SeedWork\Domain\Events\EventDomainInterface;

interface EventManagerInterface
{
    public function dispatch(EventDomainInterface $event): void;
}

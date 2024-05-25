<?php

namespace Core\SeedWork\Domain\Events;

interface EventDomainInterface
{
    public function getEventName(): string;

    public function getPayload(): array;
}

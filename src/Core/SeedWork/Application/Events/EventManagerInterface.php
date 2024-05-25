<?php

namespace Core\SeedWork\Application\Events;

interface EventManagerInterface
{
    public function dispatch(object $object): void;
}

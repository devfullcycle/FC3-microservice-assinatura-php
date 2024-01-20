<?php

namespace Core\SeedWork\Domain\Traits;

trait MethodsMagicTrait
{
    public function __get($property)
    {
        return $this->{$property};
    }

    public function id(): string
    {
        return $this->id;
    }
}

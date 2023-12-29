<?php

namespace Core\Plan\Domain;

class Plan
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $description,
    ) {
    }
    
    public function __get($property)
    {
        return $this->{$property};
    }

    public function id(): string
    {
        return $this->id;
    }
}

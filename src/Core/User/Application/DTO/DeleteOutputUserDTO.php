<?php

namespace Core\User\Application\DTO;

class DeleteOutputUserDTO
{
    public function __construct(
        public readonly bool $deleted,
    ) {
    }
}

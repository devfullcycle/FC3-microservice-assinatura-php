<?php

namespace Core\User\Application\DTO;

class InputFindAllUsersDTO
{
    public function __construct(
        public string $filter = '',
        public string $orderBy = 'DESC',
    ) {
    }
}

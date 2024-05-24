<?php

namespace Core\User\Application\DTO;

class InputUsersDTO
{
    public function __construct(
        public string $filter = '',
        public string $orderBy = 'desc',
        public int $page = 1,
        public int $totalPerPage = 15
    ) {
    }
}

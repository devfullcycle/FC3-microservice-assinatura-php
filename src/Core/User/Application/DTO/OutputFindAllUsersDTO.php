<?php

namespace Core\User\Application\DTO;

class OutputFindAllUsersDTO
{
    public function __construct(
        /**
         * @return array<OutUserDTO>
         */
        public array $items,
        public int $total,
    ) {
    }
}

<?php

namespace Core\User\Application\DTO;

class OutputUsersDTO
{
    public function __construct(
        /**
         * @return array<OutUserDTO>
         */
        public array $items,
        public int $total,
        public int $last_page,
        public int $total_per_page,
        public ?int $first_page,
        public ?int $next_page,
        public ?int $previous_page,
    ) {
    }
}

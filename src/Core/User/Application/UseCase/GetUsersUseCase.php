<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\InputUsersDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Application\DTO\OutputUsersDTO;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class GetUsersUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(InputUsersDTO $input): OutputUsersDTO
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            orderBy: $input->orderBy,
            page: $input->page,
            totalPerPage: $input->totalPerPage
        );

        return new OutputUsersDTO(
            items: $this->convertStdClassToDTO($response->items()),
            total: $response->total(),
            last_page: $response->lastPage(),
            first_page: $response->firstPage(),
            total_per_page: $response->totalPerPage(),
            next_page: $response->nextPage(),
            previous_page: $response->previousPage(),
        );
    }

    /**
     * @return array<OutputUserDTO>
     */
    private function convertStdClassToDTO(array $items = []): array
    {
        return array_map(function ($stdClass) {
            return new OutputUserDTO(
                id: $stdClass->id,
                name: $stdClass->name,
                last_name: $stdClass->last_name,
                full_name: $stdClass->name . ' ' . $stdClass->last_name,
                age: $stdClass->age,
                address: [
                    'street' => $stdClass->address->street,
                    'number' => $stdClass->address->number ?? null,
                    'city' => $stdClass->address->city,
                    'state' => $stdClass->address->state,
                    'country' => $stdClass->address->country,
                    'zip_code' => $stdClass->address->zip_code,
                ],
                type: $stdClass->type
            );
        }, $items);
    }
}

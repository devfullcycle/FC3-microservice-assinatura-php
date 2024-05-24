<?php

use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\User\Application\DTO\CreateUserDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Application\UseCase\CreateUserUseCase;

use function Pest\Laravel\assertDatabaseHas;

test('should be create new user', function () {
    $useCase = app(CreateUserUseCase::class);
    $response = $useCase->execute(new CreateUserDTO(
        name: 'test name',
        lastName: 'test last name',
        age: 18,
        address: new Address(
            city: 'test city',
            state: 'test state',
            country: 'test country',
            zipCode: '75700-000',
            street: 'test street',
        ),
        type: new CpfVO('767.143.600-37'),
    ));

    expect($response)->toBeInstanceOf(OutputUserDTO::class);
    assertDatabaseHas('users', [
        'name' => 'test name',
    ]);
    assertDatabaseHas('addresses', [
        'city' => 'test city',
    ]);
});

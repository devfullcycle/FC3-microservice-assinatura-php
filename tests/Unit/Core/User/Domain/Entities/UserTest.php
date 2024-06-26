<?php

use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\User\Domain\Entities\User;
use Faker\Factory;

beforeEach(function () {
    $this->addressVO = new Address(
        city: 'São Paulo',
        state: 'São Paulo',
        country: 'Brasil',
        zipCode: '12345-678',
        street: 'Avenida Brigadeiro Faria Lima',
    );
    $this->typeCpf = new CpfVO('044.330.860-88');
    $this->typeCnpj = new CnpjVO('54.046.611/0001-08');
});

it('should access all properties', function () {
    $user = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    expect($user->name)->toBe('Carlos');
    expect($user->lastName)->toBe('Ferreira');
    expect($user->age)->toBe(31);
    expect($user->fullName())->toBe('Carlos Ferreira');

    expect($user->id)->not->toBeNull();
    expect($user->id())->toBeString();
    expect($user->name)->toBeString();
    expect($user->lastName)->toBeString();
    expect($user->age)->toBeInt();
});

it('should access all properties - value objects', function () {
    $user = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    expect($user->address->street)->toBe('Avenida Brigadeiro Faria Lima');
    expect((string) $user->type)->toBe('044.330.860-88');

    $userPj = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCnpj,
    );
    expect((string) $userPj->type)->toBe('54.046.611/0001-08');
});

it('should use uuid passed', function () {
    $id = Uuid::random();
    $user = new User(
        id: $id,
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    expect($user->id)->toBe($id);
    expect($user->id())->toBe((string) $id);
});

it('should throws exceptions when name is wrong - less 2', function () {
    new User(
        name: 'Ca',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
})->throws(EntityValidationException::class, 'The value must be at least 3 characters');

it('should throws exceptions when name is wrong - more 255', function () {
    $name = Factory::create()->sentence(255);
    new User(
        name: $name,
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
})->throws(EntityValidationException::class, 'The value must not be greater than 255 characters');

it('should throws exceptions when lastName is wrong - less 2', function () {
    new User(
        name: 'Carlos',
        lastName: 'Fe',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
})->throws(EntityValidationException::class, 'The value must be at least 3 characters');

it('should throws exceptions when lastName is wrong - more 10000', function () {
    $lastName = Factory::create()->sentence(10000);
    new User(
        name: 'Carlos',
        lastName: $lastName,
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
})->throws(EntityValidationException::class, 'The value must not be greater than 255 characters');

it('should update values entity', function () {
    $user = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    $user->update(
        name: 'Carlos updated',
        lastName: 'Ferreira updated'
    );
    expect($user->name)->toBe('Carlos updated');
    expect($user->lastName)->toBe('Ferreira updated');
    expect($user->age)->toBe(31);

    $user->update(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 32,
    );
    expect($user->name)->toBe('Carlos');
    expect($user->lastName)->toBe('Ferreira');
    expect($user->age)->toBe(32);
});

it('should throws exception when update entity with wrong name', function () {
    $user = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    $user->update(
        name: 'Ca',
        lastName: 'Ferreira',
        age: 31,
    );
})->throws(EntityValidationException::class);

it('should throws exception when update entity with wrong lastName', function () {
    $user = new User(
        name: 'Carlos',
        lastName: 'Ferreira',
        age: 31,
        address: $this->addressVO,
        type: $this->typeCpf,
    );
    $user->update(
        name: 'Carlos',
        lastName: 'Fe',
        age: 31,
    );
})->throws(EntityValidationException::class);

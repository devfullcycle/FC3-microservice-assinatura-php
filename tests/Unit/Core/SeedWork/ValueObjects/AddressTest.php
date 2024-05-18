<?php

use Core\SeedWork\Domain\ValueObjects\Address;
use InvalidArgumentException;

test('should be able to create an address', function () {
    $address = new Address(
        street: 'street',
        city: 'city',
        state: 'state',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );

    expect($address->street)->toBe('street');
    expect($address->city)->toBe('city');
    expect($address->state)->toBe('state');
    expect($address->country)->toBe('country');
    expect($address->zipCode)->toBe('75700-000');
    expect($address->number)->toBe('1212');
});

test('should throw an exception when creating an address with invalid street', function () {
    new Address(
        street: 'st',
        city: 'city',
        state: 'state',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );
})->throws(InvalidArgumentException::class);

test('should throw an exception when creating an address with invalid city', function () {
    new Address(
        street: 'street',
        city: 'ci',
        state: 'state',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );
})->throws(InvalidArgumentException::class);

test('should throw an exception when creating an address with invalid state', function () {
    new Address(
        street: 'street',
        city: 'city',
        state: 'st',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );
})->throws(InvalidArgumentException::class);

test('should throw an exception when creating an address with invalid country', function () {
    new Address(
        street: 'street',
        city: 'city',
        state: 'state',
        country: 'co',
        zipCode: '75700-000',
        number: 1212,
    );
})->throws(InvalidArgumentException::class);

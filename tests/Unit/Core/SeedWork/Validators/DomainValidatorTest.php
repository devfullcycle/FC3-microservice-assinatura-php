<?php

use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Core\SeedWork\Domain\Validators\DomainValidator;
use Faker\Factory;

test('should throw exception when value is null', function () {
    DomainValidator::notNull(value: null);
})->throws(EntityValidationException::class, 'Should not be empty');

test('should throw exception when value is null - and custom message exception', function () {
    DomainValidator::notNull(value: null, exceptionMessage: 'not be null');
})->throws(EntityValidationException::class, 'not be null');

test('should be string and max characters', function () {
    $value = Factory::create()->sentence(255);
    DomainValidator::strMaxLength(value: $value);
})->throws(EntityValidationException::class, 'The value must not be greater than 255 characters');

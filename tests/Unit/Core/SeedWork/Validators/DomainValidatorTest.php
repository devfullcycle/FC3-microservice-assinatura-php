<?php

use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Core\SeedWork\Domain\Validators\DomainValidator;

test('should throw exception when value is null', function () {
    DomainValidator::notNull(value: null);
})->throws(EntityValidationException::class, 'Should not be empty');

test('should throw exception when value is null - and custom message exception', function () {
    DomainValidator::notNull(value: null, exceptionMessage: 'not be null');
})->throws(EntityValidationException::class, 'not be null');

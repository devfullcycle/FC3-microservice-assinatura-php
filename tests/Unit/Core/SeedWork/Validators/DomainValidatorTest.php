<?php

use Core\SeedWork\Domain\Exceptions\EntityValidation;
use Core\SeedWork\Domain\Validators\DomainValidator;

test('should throw exception when value is null', function () {
    DomainValidator::notNull(value: null);
})->throws(EntityValidation::class, 'Should not be empty');

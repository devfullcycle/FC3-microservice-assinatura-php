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

test('should be string and max characters - with custom length', function () {
    DomainValidator::strMaxLength(value: 'abcd', length: 2);
})->throws(EntityValidationException::class, 'The value must not be greater than 2 characters');

test('should be string and max characters - with custom length - with custom message error', function () {
    DomainValidator::strMaxLength(value: 'abcde', length: 4, exceptionMessage: 'need be less 2');
})->throws(EntityValidationException::class, 'need be less 2');

test('should be string and min characters', function () {
    DomainValidator::strMinLength(value: 'a');
})->throws(EntityValidationException::class, 'The value must be at least 3 characters');

test('should be string and min characters - with custom length', function () {
    DomainValidator::strMinLength(value: 'abcd', length: 10);
})->throws(EntityValidationException::class, 'The value must be at least 10 characters');

test('should be string and min characters - with custom length - with custom message error', function () {
    DomainValidator::strMinLength(value: 'abc', length: 4, exceptionMessage: 'need be more 2');
})->throws(EntityValidationException::class, 'need be more 2');

test('should be null or max string length', function () {
    DomainValidator::strCanNullAndMaxLength(value: null);
    expect(true)->toBeTrue();
});

test('should throws exceptions when string max length', function () {
    $value = Factory::create()->sentence(255);
    DomainValidator::strCanNullAndMaxLength(value: $value);
})->throws(EntityValidationException::class, 'The value must not be greater than 255 characters');

test('should throws exceptions when string max length - custom length', function () {
    DomainValidator::strCanNullAndMaxLength(value: 'abcd', length: 2);
})->throws(EntityValidationException::class, 'The value must not be greater than 2 characters');

test('should throws exceptions when string max length - custom length - custom message', function () {
    DomainValidator::strCanNullAndMaxLength(value: 'abcd', length: 2, exceptionMessage: 'need be less 2');
})->throws(EntityValidationException::class, 'need be less 2');

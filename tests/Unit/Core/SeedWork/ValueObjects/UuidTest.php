<?php

use Core\SeedWork\Domain\ValueObjects\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

test('should throw exception when receive invalid uuid', function () {
    new Uuid('invalid_uuid');
})->throws(InvalidArgumentException::class);

test('should works when receive valid uuid in constructor', function () {
    $uuid = RamseyUuid::uuid4();
    $vo = (string) new Uuid($uuid);
    expect($vo)->toBeString();
});

test('should create valid uuid', function () {
    expect(RamseyUuid::isValid(Uuid::random()))->toBeTrue();
});

test('should return self instance', function () {
    expect(Uuid::random())->toBeInstanceOf(Uuid::class);
});

test('should return string', function () {
    $uuid = (string) Uuid::random();
    expect($uuid)->toBeString();
});

<?php

use Core\SeedWork\Domain\ValueObjects\CnpjVO;

test('should be able to create a CNPJ', function () {
    $cnpj = new CnpjVO('09.267.179/0001-12');
    expect((string) $cnpj)->toBeString();
    expect((string) $cnpj)->toBe('09.267.179/0001-12');
});

test('should throws an exception when creating a invalid cnpj', function () {
    new CnpjVO('11.111.111/1111-11');
})->throws(InvalidArgumentException::class);

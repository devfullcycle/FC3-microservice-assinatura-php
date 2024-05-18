<?php

use Core\SeedWork\Domain\ValueObjects\CpfVO;

test('should be able to create a Cpf', function () {
    $cpf = new CpfVO('888.314.690-53');
    expect((string) $cpf)->toBeString();
    expect((string) $cpf)->toBe('888.314.690-53');
});

test('should throws an exception when creating a invalid Cpf', function () {
    new CpfVO('111.111.111-11');
})->throws(InvalidArgumentException::class);

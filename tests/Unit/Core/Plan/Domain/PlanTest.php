<?php

use Core\Plan\Domain\Plan;

it('should exists entity', function () {
    $plan = new Plan;
    expect(true)->toBe(true);
});

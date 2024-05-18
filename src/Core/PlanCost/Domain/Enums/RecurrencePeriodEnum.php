<?php

namespace Core\PlanCost\Domain\Enums;

enum RecurrencePeriodEnum: string
{
    case ANNUALLY = 'annually';
    case MONTHLY = 'monthly';
}

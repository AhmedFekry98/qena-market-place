<?php

namespace App\Enums;

enum Operator: string
{
    case Equal = '=';
    case GreaterThan = '>';
    case LessThan = '<';
    case GreaterThanOrEqual = '>=';
    case LessThanOrEqual = '<=';
}

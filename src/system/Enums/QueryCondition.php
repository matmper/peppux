<?php

namespace System\Enums;

use System\Peppux\Trait\ArrayableEnum;

enum QueryCondition: string
{
    use ArrayableEnum;

    case EQUAL = '=';
    case GREATER = '>';
    case LESS = '<';
    case GREATER_OR_EQUAL = '>=';
    case LESS_OR_EQUAL = '<=';
    case GREATER_OR_LESS = '<>';
    case DIFFERENT = '!=';
    case LIKE = 'LIKE';
    case NOT_LIKE = 'NOT_LIKE';
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
}

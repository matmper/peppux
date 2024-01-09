<?php

namespace System\Enums;

use System\Peppux\Enum;

class QueryCondition extends Enum
{
    const EQUAL = '=';
    const GREATER = '>';
    const LESS = '<';
    const GREATER_OR_EQUAL = '>=';
    const LESS_OR_EQUAL = '<=';
    const GREATER_OR_LESS = '<>';
    const DIFFERENT = '!=';
    const LIKE = 'LIKE';
    const NOT_LIKE = 'NOT_LIKE';
    const IN = 'IN';
    const NOT_IN = 'NOT IN';
}

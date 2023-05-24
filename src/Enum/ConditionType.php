<?php

declare(strict_types=1);

namespace App\Enum;

enum ConditionType: string
{
    case NEW = "NEW";
    case USED = "USED";
    case CRASHED = "CRASHED";
    case BROKEN = "BROKEN";
    case FOR_PARTS = "FOR_PARTS";
}

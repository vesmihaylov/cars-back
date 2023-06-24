<?php

declare(strict_types=1);

namespace App\Enum;

enum FuelType: string
{
    case PETROL = "PETROL";
    case DIESEL = "DIESEL";
    case GAS_AND_PETROL = "GAS_AND_PETROL";
    case METHANE_AND_PETROL = "METHANE_AND_PETROL";
    case HYBRID = "HYBRID";
    case ELECTRIC = "ELECTRIC";
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum FuelType: string
{
    case PETROL = "Бензин";
    case DIESEL = "Дизел";
    case GAS_AND_PETROL = "Газ/Бензин";
    case METHANE_AND_PETROL = "Метан/Бензин";
    case HYBRID = "Хибрид";
    case ELECTRIC = "Електричество";
}

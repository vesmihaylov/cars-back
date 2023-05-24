<?php

declare(strict_types=1);

namespace App\Enum;

enum CoupeType: string
{
    case SEDAN = "SEDAN";
    case HATCHBACK = "HATCHBACK";
    case WAGON = "WAGON";
    case COUPE = "COUPE";
    case CONVERTIBLE = "CONVERTIBLE";
    case SUV = "SUV";
    case PICKUP = "PICKUP";
    case VAN = "VAN";
    case HEARSE = "HEARSE";
}

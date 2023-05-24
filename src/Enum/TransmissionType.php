<?php

declare(strict_types=1);

namespace App\Enum;

enum TransmissionType: string
{
    case MANUAL = "MANUAL";
    case AUTOMATIC = "AUTOMATIC";
}

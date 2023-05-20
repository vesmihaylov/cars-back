<?php

declare(strict_types=1);

namespace App\Enum;

enum FeatureType: string
{
    case SECURITY = "SECURITY";
    case COMFORT = "COMFORT";
    case OTHER = "OTHER";
}

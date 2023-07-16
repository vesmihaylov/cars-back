<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\{
    ConditionType,
    CoupeType,
    FuelType,
    TransmissionType,
    WheelType
};
use Symfony\Component\{
    Validator\Constraints as Assert,
    Uid\Uuid
};

/**
 * Publish Deal Request DTO
 */
class PublishDealRequest
{
    #[Assert\Type('string')]
    public string|null $additionalTitle = null;

    #[Assert\Type('string')]
    public string|null $description;

    #[Assert\Uuid(message: 'Невалиден формат или празна стойност.')]
    public Uuid $brandId;

    #[Assert\Uuid(message: 'Невалиден формат или празна стойност.')]
    public Uuid $modelId;

    #[Assert\Uuid(message: 'Невалиден формат или празна стойност.')]
    public Uuid $cityId;

    #[Assert\Type(type: ConditionType::class)]
    public string $conditionType;

    #[Assert\Type(type: CoupeType::class)]
    public string $coupeType;

    #[Assert\Type(type: TransmissionType::class)]
    public string $transmissionType;

    #[Assert\Type(type: WheelType::class)]
    public string $wheelType;

    #[Assert\Type(type: FuelType::class)]
    public string $fuelType;

    #[Assert\Type('array')]
    public array $features = [];

    #[Assert\Type('integer')]
    public int $horsePower;

    #[Assert\Type('integer')]
    public int $price;

    #[Assert\Type('integer')]
    public int $year;

    #[Assert\Type('integer')]
    public int $mileage;
}

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
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Publish Deal Request DTO
 */
class PublishDealRequest
{
    #[Assert\Type('string')]
    public string $title;

    #[Assert\Type('string')]
    public string|null $additionalTitle = null;

    #[Assert\Type('string')]
    public string|null $description = null;

    #[Assert\Uuid]
    public Uuid $brandId;

    #[Assert\Uuid]
    public Uuid $modelId;

    #[Assert\Uuid]
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

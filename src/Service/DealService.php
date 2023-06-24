<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PublishDealRequest;
use App\Entity\{
    City,
    Deal,
    DealFeature,
    Feature
};
use App\Enum\{
    ConditionType,
    CoupeType,
    FuelType,
    TransmissionType,
    WheelType
};
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Response
};

class DealService
{
    public function __construct(readonly private EntityManagerInterface $entityManager)
    {
    }

    public function publish(PublishDealRequest $data): JsonResponse
    {
        try {
            $deal = new Deal();
            $city = $this->entityManager->getRepository(City::class)->find($data->cityId);
            if ($data->features) {
                foreach ($data->features as $featureId) {
                    $feature = $this->entityManager->getRepository(Feature::class)->find($featureId);
                    $dealFeature = new DealFeature();
                    $dealFeature->setDeal($deal);
                    $dealFeature->setFeature($feature);
                    $this->entityManager->persist($dealFeature);
                }
            }

            $deal
                ->setTitle($data->title)
                ->setYear($data->year)
                ->setTransmissionType(TransmissionType::from($data->transmissionType))
                ->setWheelType(WheelType::from($data->wheelType))
                ->setConditionType(ConditionType::from($data->conditionType))
                ->setCoupeType(CoupeType::from($data->coupeType))
                ->setDescription($data->description)
                ->setFuelType(FuelType::from($data->fuelType))
                ->setHorsePower($data->horsePower)
                ->setPrice($data->price)
                ->setMileage($data->mileage)
                ->setCity($city)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime());

            $this->entityManager->persist($deal);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Успешно добавена обява.'], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Нещо се обърка, свържете се с нас при проблем.'], Response::HTTP_BAD_REQUEST);
        }
    }
}

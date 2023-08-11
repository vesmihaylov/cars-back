<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PublishDealRequest;
use App\Service\DealService;
use Symfony\{
    Bundle\FrameworkBundle\Controller\AbstractController,
    Component\HttpFoundation\JsonResponse,
    Component\HttpFoundation\Request,
    Component\HttpKernel\Attribute\AsController,
    Component\Serializer\SerializerInterface
};

#[AsController]
class CreateDeal extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DealService $dealService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $normalizedResponse = $this->serializer->decode($request->getContent(), 'json');
        $encodedData = json_encode($normalizedResponse['data']);
        $dto = $this->serializer->deserialize($encodedData, PublishDealRequest::class, 'json');

        return $this->dealService->publish($dto);
    }
}

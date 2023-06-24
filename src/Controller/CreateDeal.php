<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PublishDealRequest;
use App\Service\DealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class CreateDeal extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DealService $dealService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), PublishDealRequest::class, 'json');
        return $this->dealService->publish($dto);
    }
}

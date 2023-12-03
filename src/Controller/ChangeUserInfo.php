<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ChangeUserInfoRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\{
    Bundle\FrameworkBundle\Controller\AbstractController,
    Component\HttpFoundation\JsonResponse,
    Component\HttpFoundation\Request,
    Component\HttpFoundation\Response,
    Component\HttpKernel\Attribute\AsController,
    Component\Serializer\SerializerInterface,
    Component\Validator\Validator\ValidatorInterface
};

#[AsController]
class ChangeUserInfo extends AbstractController
{
    public function __construct(
        private readonly UserRepository         $userRepository,
        readonly private LoggerInterface        $logger,
        private readonly SerializerInterface    $serializer,
        private readonly ValidatorInterface     $validator,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $normalizedResponse = $this->serializer->decode($request->getContent(), 'json');
        $encodedData = json_encode($normalizedResponse['data']);
        $userId = $normalizedResponse['data']['id'] ?? null;
        if (!$userId) {
            return new JsonResponse(['message' => 'ID на потребител не е подадено.'], Response::HTTP_BAD_REQUEST);
        }

        $dto = $this->serializer->deserialize($encodedData, ChangeUserInfoRequest::class, 'json');
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return new JsonResponse(['message' => $violations[0]->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            return new JsonResponse(['message' => 'Потребителят не беше намерен.'], Response::HTTP_NOT_FOUND);
        }

        try {
            $user
                ->setName($dto->name ?? $user->getName())
                ->setEmail($dto->email ?? $user->getEmail())
                ->setPhoneNumber($dto->phoneNumber ?? $user->getPhoneNumber());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Успешна промяна.'], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), [$e->getTraceAsString()]);

            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

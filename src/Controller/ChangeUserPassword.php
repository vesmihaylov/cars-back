<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ChangeUserPasswordRequest;
use App\Entity\User;
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
    Component\PasswordHasher\Hasher\UserPasswordHasherInterface,
    Component\Serializer\SerializerInterface,
    Component\Validator\Validator\ValidatorInterface
};

#[AsController]
class ChangeUserPassword extends AbstractController
{
    public function __construct(
        private readonly UserRepository              $userRepository,
        readonly private LoggerInterface             $logger,
        private readonly SerializerInterface         $serializer,
        private readonly ValidatorInterface          $validator,
        private readonly EntityManagerInterface      $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $normalizedResponse = $this->serializer->decode($request->getContent(), 'json');
        $encodedData = json_encode($normalizedResponse['data']);

        $dto = $this->serializer->deserialize($encodedData, ChangeUserPasswordRequest::class, 'json');
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return new JsonResponse(['message' => $violations[0]->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->find($dto->userId);
        if (!$user) {
            return new JsonResponse(['message' => 'Потребителят не беше намерен.'], Response::HTTP_NOT_FOUND);
        }

        $temporaryUser = new User();

        if ($dto->newPassword !== $dto->repeatNewPassword) {
            return new JsonResponse(['message' => 'Грешно повторена парола.'], Response::HTTP_BAD_REQUEST);
        }

        if (!$this->passwordHasher->isPasswordValid($user, $dto->oldPassword)) {
            return new JsonResponse(['message' => 'Грешна парола!'], Response::HTTP_BAD_REQUEST);
        }

        $hashedNewPassword = $this->passwordHasher->hashPassword(
            $temporaryUser,
            $dto->newPassword
        );

        try {
            $user
                ->setPassword($hashedNewPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Успешна промяна на паролата.'], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), [$e->getTraceAsString()]);

            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

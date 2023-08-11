<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CreateUserRequest;
use App\Entity\User;
use App\Repository\UserRepository;
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
class RegisterUser extends AbstractController
{
    public function __construct(
        private readonly UserRepository              $userRepository,
        readonly private LoggerInterface             $logger,
        private readonly SerializerInterface         $serializer,
        private readonly ValidatorInterface          $validator,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUserRequest::class, 'json');
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return new JsonResponse(['message' => $violations[0]->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'email' => $dto->email,
            'name' => $dto->name,
            'password' => $this->hashPassword($dto->password),
            'phoneNumber' => $dto->phoneNumber,
            'type' => $dto->type,
            'role' => $dto->type === 'SELLER' ? 'ROLE_SELLER' : 'ROLE_COMPANY'
        ];

        try {
            $this->userRepository->create($data);
            return new JsonResponse(['message' => 'Успешна регистрация.'], Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), [$e->getTraceAsString()]);
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function hashPassword(string $password): string
    {
        $temporaryUser = new User();

        return $this->passwordHasher->hashPassword(
            $temporaryUser,
            $password
        );
    }
}

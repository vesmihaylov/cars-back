<?php

namespace App\Entity;

use ApiPlatform\{
    Metadata\ApiResource,
    Metadata\Post,
    OpenApi\Model\Operation,
    OpenApi\Model\RequestBody
};
use App\Controller\CreateUser;
use App\Repository\UserRepository;
use Doctrine\{
    Common\Collections\ArrayCollection,
    Common\Collections\Collection,
    ORM\Mapping as ORM
};
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\{
    Types\UuidType,
    Validator\Constraints\UniqueEntity
};
use Symfony\Component\{Security\Core\User\PasswordAuthenticatedUserInterface,
    Security\Core\User\UserInterface,
    Serializer\Annotation\Groups,
    Serializer\Annotation\SerializedName,
    Uid\Uuid,
    Validator\Constraints as Assert
};

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/users',
            controller: CreateUser::class,
            openapi: new Operation(
                responses: [
                    '201' => [
                        'description' => 'Успешна регистрация.'
                    ],
                    '400' => [
                        'description' => 'Нещо се обърка, свържете се с нас при проблем.'
                    ]
                ],
                summary: 'Create an user',
                description: 'Register a new user.',
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'email' => ['type' => 'string'],
                                    'phoneNumber' => ['type' => 'string'],
                                    'password' => ['type' => 'string'],
                                ]
                            ],
                            'example' => [
                                'name' => 'John Doe',
                                'email' => 'jdoe@gmail.com',
                                'phoneNumber' => '359111111111',
                                'password' => 'strongPassword',
                            ]
                        ]
                    ])
                )

            ),
            read: false,
            deserialize: false,
            name: 'user_create'
        ),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[UniqueEntity(fields: ['email'], message: 'Тази електронна поща вече съществува.')]
#[UniqueEntity(fields: ['name'], message: 'Това име вече съществува.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['user:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Deal::class, orphanRemoval: true)]
    private Collection $deals;

    #[ORM\Column(length: 12)]
    #[Assert\NotBlank]
    #[Groups(['user:read'])]
    private ?string $phoneNumber = null;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    #[Groups(['user:read'])]
    #[SerializedName('createdAt')]
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    #[Groups(['user:read', 'user:write'])]
    #[SerializedName('updatedAt')]
    public function getUpdatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Deal>
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals->add($deal);
            $deal->setOwner($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getOwner() === $this) {
                $deal->setOwner(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}

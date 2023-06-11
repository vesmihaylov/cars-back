<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Enum\FeatureType;
use App\Repository\FeatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FeatureRepository::class)]
#[ORM\Table(name: 'features')]
#[ApiResource(paginationEnabled: false)]
#[GetCollection(normalizationContext: ['groups' => ['features:read']])]
class Feature
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['features:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['features:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 30, enumType: FeatureType::class)]
    #[Groups(['features:read'])]
    private FeatureType $type;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getType(): FeatureType
    {
        return $this->type;
    }

    public function setType(FeatureType $type): self
    {
        $this->type = $type;

        return $this;
    }
}

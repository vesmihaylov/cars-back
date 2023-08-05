<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DealFeatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\{
    Serializer\Annotation\Groups,
    Uid\Uuid
};

#[ORM\Entity(repositoryClass: DealFeatureRepository::class)]
#[ORM\Table(name: 'deal_features')]
#[ApiResource]
class DealFeature
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'dealFeatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Deal $deal = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['deal:read'])]
    private ?Feature $feature = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDeal(): ?Deal
    {
        return $this->deal;
    }

    public function setDeal(?Deal $deal): self
    {
        $this->deal = $deal;

        return $this;
    }

    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    public function setFeature(?Feature $feature): self
    {
        $this->feature = $feature;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\{
    ApiResource,
    Get,
    Post
};
use App\Repository\FavouriteDealRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavouriteDealRepository::class)]
#[ORM\UniqueConstraint(columns: ['deal_id', 'owner_id'])]
#[ORM\Table(name: 'favourite_deals')]
#[ApiResource(
    operations: [
        new Get(),
        new Post()
    ]
)]
class FavouriteDeal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favouriteDeals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Deal $deal = null;

    #[ORM\ManyToOne(inversedBy: 'favouriteDeals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}

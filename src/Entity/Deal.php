<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\FuelType;
use App\Repository\DealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DealRepository::class)]
#[ORM\Table(name: 'deals')]
#[ApiResource]
class Deal
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: 'string', enumType: FuelType::class)]
    private FuelType $fuelType;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: DealFeature::class, orphanRemoval: true)]
    private Collection $dealFeatures;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getFuelType(): FuelType
    {
        return $this->fuelType;
    }

    public function setFuelType(FuelType $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __construct()
    {
        // Set default fuel type
        $this->fuelType = FuelType::PETROL;
        $this->dealFeatures = new ArrayCollection();
    }

    /**
     * @return Collection<int, DealFeature>
     */
    public function getDealFeatures(): Collection
    {
        return $this->dealFeatures;
    }

    public function addDealFeature(DealFeature $dealFeature): self
    {
        if (!$this->dealFeatures->contains($dealFeature)) {
            $this->dealFeatures->add($dealFeature);
            $dealFeature->setDeal($this);
        }

        return $this;
    }

    public function removeDealFeature(DealFeature $dealFeature): self
    {
        if ($this->dealFeatures->removeElement($dealFeature)) {
            // set the owning side to null (unless already changed)
            if ($dealFeature->getDeal() === $this) {
                $dealFeature->setDeal(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\ConditionType;
use App\Enum\CoupeType;
use App\Enum\FuelType;
use App\Enum\TransmissionType;
use App\Enum\WheelType;
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

    #[ORM\Column(type: 'string', enumType: TransmissionType::class)]
    private TransmissionType $transmissionType;

    #[ORM\Column(type: 'string', enumType: WheelType::class)]
    private WheelType $wheelType;

    #[ORM\Column(type: 'string', enumType: ConditionType::class)]
    private ConditionType $conditionType;

    #[ORM\Column(type: 'string', enumType: CoupeType::class)]
    private CoupeType $coupeType;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column]
    private ?int $horsePower = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: DealFeature::class, orphanRemoval: true)]
    private Collection $dealFeatures;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

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

    public function getTransmissionType(): TransmissionType
    {
        return $this->transmissionType;
    }

    public function setTransmissionType(TransmissionType $transmissionType): self
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    public function getWheelType(): WheelType
    {
        return $this->wheelType;
    }

    public function setWheelType(WheelType $wheelType): self
    {
        $this->wheelType = $wheelType;

        return $this;
    }

    public function getConditionType(): ConditionType
    {
        return $this->conditionType;
    }

    public function setConditionType(ConditionType $conditionType): self
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    public function getCoupeType(): CoupeType
    {
        return $this->coupeType;
    }

    public function setCoupeType(CoupeType $coupeType): self
    {
        $this->coupeType = $coupeType;

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

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): self
    {
        $this->horsePower = $horsePower;

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
        $this->wheelType = WheelType::LEFT;
        $this->transmissionType = TransmissionType::MANUAL;
        $this->coupeType = CoupeType::SEDAN;
        $this->conditionType = ConditionType::USED;
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}

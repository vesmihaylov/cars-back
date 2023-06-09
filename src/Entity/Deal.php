<?php

namespace App\Entity;

use ApiPlatform\Metadata\{
    ApiResource,
    Delete,
    Get,
    GetCollection,
    Post,
    Put
};
use App\Controller\CreateDeal;
use App\Enum\{
    ConditionType,
    CoupeType,
    FuelType,
    TransmissionType,
    WheelType
};
use App\Repository\DealRepository;
use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\OpenApi\Model\{
    Operation,
    RequestBody
};

#[ORM\Entity(repositoryClass: DealRepository::class)]
#[ORM\Table(name: 'deals')]
#[ApiResource(operations: [
    new Get(),
    new GetCollection(),
    new Post(
        uriTemplate: '/deals',
        controller: CreateDeal::class,
        openapi: new Operation(
            responses: [
                '201' => [
                    'description' => 'Успешно добавена обява.'
                ],
                '400' => [
                    'description' => 'Нещо се обърка, свържете се с нас при проблем.'
                ]
            ],
            summary: 'Publish a deal',
            description: 'Publish a new car deal.',
            requestBody: new RequestBody(
                content: new \ArrayObject([
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'additionalTitle' => ['type' => 'string'],
                                'description' => ['type' => 'string'],
                                'brandId' => ['type' => 'uuid'],
                                'cityId' => ['type' => 'uuid'],
                                'conditionType' => ['type' => 'string'],
                                'coupeType' => ['type' => 'string'],
                                'fuelType' => ['type' => 'string'],
                                'transmissionType' => ['type' => 'string'],
                                'wheelType' => ['type' => 'string'],
                                'price' => ['type' => 'integer'],
                                'year' => ['type' => 'integer'],
                                'mileage' => ['type' => 'integer'],
                                'horsePower' => ['type' => 'integer'],
                                'features' => ['type' => 'array']
                            ]
                        ],
                        'example' => [
                            'additionalTitle' => 'FACELIFT, обслужена',
                            'description' => 'Нормални забележки за годините си, обслужена, винетка до грая на годината.',
                            'brandId' => '6ecff723-18ad-4665-933a-b8a230c0f4d1',
                            'modelId' => '2f791100-b9ae-4f20-831b-02937854601e',
                            'cityId' => 'ce22b891-fe3a-4d3d-a5cd-199c94a42d77',
                            'conditionType' => 'USED',
                            'coupeType' => 'SEDAN',
                            'fuelType' => 'DIESEL',
                            'transmissionType' => 'MANUAL',
                            'wheelType' => 'LEFT',
                            'price' => 13500,
                            'year' => 2007,
                            'mileage' => 250455,
                            'horsePower' => 170,
                            'features' => [
                                '1d17faa6-41d9-4728-ae36-e0c140719dbf',
                                '784117c3-2abe-428d-ae93-2370b0dd6248',
                                '7d110dc3-7110-4455-b253-060b20fd4664'
                            ]
                        ]
                    ]
                ])
            )

        ),
        read: false,
        deserialize: false,
        name: 'deal_publish'
    ),
    new Delete(),
    new Put()
])]
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

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;

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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }
}

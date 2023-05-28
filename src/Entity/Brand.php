<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ORM\Table(name: 'brands')]
#[ApiResource(order: ['name' => 'ASC'], paginationEnabled: false)]
#[GetCollection(normalizationContext: ['groups' => ['brands:read']])]
class Brand
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['brands:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['brands:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Model::class, orphanRemoval: true)]
    private Collection $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }
}

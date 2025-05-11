<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SmartphoneRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\DistinctValuesController;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SmartphoneRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['smartphone:read']],
    denormalizationContext: ['groups' => ['smartphone:write']]
)]
#[UniqueEntity(
    fields: ['uniqueIdentifier'],
    message: 'This unique identifier is already in use.',
    errorPath: 'uniqueIdentifier'
)]
#[Get(
    normalizationContext: ['groups' => ['smartphone:read', 'smartphone:item:read']]
)]
#[GetCollection(
    paginationEnabled: true,
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 30,
    paginationMaximumItemsPerPage: 100,
    filters: [
        'smartphone.search_filter',
        'smartphone.range_filter',
        'smartphone.order_filter',
        'smartphone.unique_identifier_filter',
        'smartphone.category_filter',
        'smartphone.brand_filter',
        'smartphone.model_filter',
        'smartphone.grade_filter',
        'smartphone.condition_filter',
        'smartphone.price_range_filter',
    ],
)]
#[GetCollection(
    uriTemplate: '/smartphones/categories',
    controller: DistinctValuesController::class . '::getCategories',
    name: 'get_categories',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false,
)]
#[GetCollection(
    uriTemplate: '/smartphones/brands',
    controller: DistinctValuesController::class . '::getBrands',
    name: 'get_brands',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false,
)]
#[GetCollection(
    uriTemplate: '/smartphones/models',
    controller: DistinctValuesController::class . '::getModels',
    name: 'get_models',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false,
)]
#[GetCollection(
    uriTemplate: '/smartphones/grade',
    controller: DistinctValuesController::class . '::getGrade',
    name: 'get_grades',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false,
)]
#[GetCollection(
    uriTemplate: '/smartphones/conditions',
    controller: DistinctValuesController::class . '::getConditions',
    name: 'get_conditions',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false,
)]
#[GetCollection(
    uriTemplate: '/smartphones/price-range',
    controller: DistinctValuesController::class . '::getPriceRange',
    name: 'get_price_range',
    normalizationContext: ['groups' => ['smartphone:read']],
    paginationEnabled: false
)]
#[Post(
    denormalizationContext: ['groups' => ['smartphone:write', 'smartphone:create']]
)]
#[Put(
    denormalizationContext: ['groups' => ['smartphone:write', 'smartphone:update']]
)]
#[Patch(
    denormalizationContext: ['groups' => ['smartphone:write', 'smartphone:update']]
)]
#[Delete]
class Smartphone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['smartphone:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    #[Assert\NotBlank(message: 'The unique identifier cannot be blank.')]
    private ?string $uniqueIdentifier = null;

    #[ORM\Column(length: 255)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    private ?string $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    private ?string $grade = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    private ?string $condition = null;

    #[ORM\Column]
    #[Groups(['smartphone:read', 'smartphone:write'])]
    #[ApiProperty(description: 'Price in cents')]
    #[Assert\NotBlank(message: 'The price cannot be blank.')]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueIdentifier(): ?string
    {
        return $this->uniqueIdentifier;
    }

    public function setUniqueIdentifier(string $uniqueIdentifier): static
    {
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(string $condition): static
    {
        $this->condition = $condition;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }
}

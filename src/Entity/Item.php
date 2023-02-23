<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['item:read']],
    denormalizationContext: ['groups' => ['item:write']],
)]
#[ApiFilter(filterClass: RangeFilter::class, properties: ['price'=>'start'])]
#[ApiFilter(filterClass: OrderFilter::class,properties:['price'=>'partial','category_id'=>'exact'],arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(filterClass: SearchFilter::class,properties: ['price'=>'start','id'=>'exact',
    'category_id'=>'exact','name'=>'start','description'=>'partial'])]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item:read','categoria:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'El nombre del producto debe tener al menos {{ limit }} caracteres ',
        maxMessage: 'El nombre del producto no puede tener más de {{ limit }} caracteres',
    )]
    #[Groups(['item:read', 'item:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 5,
        max: 500,
        minMessage: 'La descripcion del producto debe tener al menos {{ limit }} caracteres ',
        maxMessage: 'La descripcion del producto no puede tener más de {{ limit }} caracteres',
    )]
    #[Groups(['item:read', 'item:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Type(
        type: 'float',
        message: 'El valor {{ value }} no es valido {{ type }}.',
    )]
    #[Assert\Positive]
    #[Groups(['item:read', 'item:write'])]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['item:read', 'item:write'])]
    private ?Category $category = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Groups(['item:read', 'item:write'])]
    private ?array $alergenos = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Groups(['item:read', 'item:write'])]
    private ?string $img = null;
    /**
     * @return array|null
     */
    public function getAlergenos(): ?array
    {
        return $this->alergenos;
    }

    /**
     * @param array|null $alergenos
     */
    public function setAlergenos(?array $alergenos): void
    {
        $this->alergenos = $alergenos;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }



    public function __construct()
    {

    }

    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
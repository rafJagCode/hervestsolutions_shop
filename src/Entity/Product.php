<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $compareAtPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productNumber;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $features = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $images = [];

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCompareAtPrice(): ?float
    {
        return $this->compareAtPrice;
    }

    public function setCompareAtPrice(?float $compareAtPrice): self
    {
        $this->compareAtPrice = $compareAtPrice;

        return $this;
    }

    public function getProductNumber(): ?int
    {
        return $this->productNumber;
    }

    public function setProductNumber(?int $productNumber): self
    {
        $this->productNumber = $productNumber;

        return $this;
    }

    public function getFeatures(): ?array
    {
        return $this->features;
    }

    public function setFeatures(?array $features): self
    {
        $this->features = $features;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }
}

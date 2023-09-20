<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $detailQuantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $detailReduction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4)]
    private ?string $detailUnitPrice = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $detailOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetailQuantity(): ?int
    {
        return $this->detailQuantity;
    }

    public function setDetailQuantity(int $detailQuantity): static
    {
        $this->detailQuantity = $detailQuantity;

        return $this;
    }

    public function getDetailReduction(): ?string
    {
        return $this->detailReduction;
    }

    public function setDetailReduction(?string $detailReduction): static
    {
        $this->detailReduction = $detailReduction;

        return $this;
    }

    public function getDetailUnitPrice(): ?string
    {
        return $this->detailUnitPrice;
    }

    public function setDetailUnitPrice(string $detailUnitPrice): static
    {
        $this->detailUnitPrice = $detailUnitPrice;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getDetailOrder(): ?Order
    {
        return $this->detailOrder;
    }

    public function setDetailOrder(?Order $detailOrder): static
    {
        $this->detailOrder = $detailOrder;

        return $this;
    }
}

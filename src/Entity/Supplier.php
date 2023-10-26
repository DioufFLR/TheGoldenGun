<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $supplierName = null;

    #[ORM\Column(length: 50)]
    private ?string $supplierPhone = null;

    #[ORM\Column(length: 50)]
    private ?string $supplierCity = null;

    #[ORM\Column(length: 100)]
    private ?string $supplierAdress = null;

    #[ORM\Column(length: 50)]
    private ?string $supplierPC = null;

    #[ORM\Column(length: 50)]
    private ?string $supplierCountry = null;

    #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: Product::class, orphanRemoval: true)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplierName(): ?string
    {
        return $this->supplierName;
    }

    public function setSupplierName(string $supplierName): static
    {
        $this->supplierName = $supplierName;

        return $this;
    }

    public function getSupplierPhone(): ?string
    {
        return $this->supplierPhone;
    }

    public function setSupplierPhone(string $supplierPhone): static
    {
        $this->supplierPhone = $supplierPhone;

        return $this;
    }

    public function getSupplierCity(): ?string
    {
        return $this->supplierCity;
    }

    public function setSupplierCity(string $supplierCity): static
    {
        $this->supplierCity = $supplierCity;

        return $this;
    }

    public function getSupplierAdress(): ?string
    {
        return $this->supplierAdress;
    }

    public function setSupplierAdress(string $supplierAdress): static
    {
        $this->supplierAdress = $supplierAdress;

        return $this;
    }

    public function getSupplierPC(): ?string
    {
        return $this->supplierPC;
    }

    public function setSupplierPC(string $supplierPC): static
    {
        $this->supplierPC = $supplierPC;

        return $this;
    }

    public function getSupplierCountry(): ?string
    {
        return $this->supplierCountry;
    }

    public function setSupplierCountry(string $supplierCountry): static
    {
        $this->supplierCountry = $supplierCountry;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getSupplierName();
        // TODO: Implement __toString() method.
    }
}

<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categoryName = null;

    #[ORM\Column(length: 100)]
    private ?string $categoryPicture = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'categorySub')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $categorySub = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class, orphanRemoval: true)]
    private Collection $products;

    public function __construct()
    {
        $this->categorySub = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getCategoryPicture(): ?string
    {
        return $this->categoryPicture;
    }

    public function setCategoryPicture(string $categoryPicture): static
    {
        $this->categoryPicture = $categoryPicture;

        return $this;
    }

    public function getCategorySub(): ?self
    {
        return $this->categorySub;
    }

    public function setCategorySub(?self $categorySub): static
    {
        $this->categorySub = $categorySub;

        return $this;
    }

    public function addCategorySub(self $categorySub): static
    {
        if (!$this->categorySub->contains($categorySub)) {
            $this->categorySub->add($categorySub);
            $categorySub->setCategorySub($this);
        }

        return $this;
    }

    public function removeCategorySub(self $categorySub): static
    {
        if ($this->categorySub->removeElement($categorySub)) {
            // set the owning side to null (unless already changed)
            if ($categorySub->getCategorySub() === $this) {
                $categorySub->setCategorySub(null);
            }
        }

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
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}

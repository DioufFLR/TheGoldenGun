<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $orderDate = null;

    #[ORM\Column(length: 100)]
    private ?string $orderDelivery = null;

    #[ORM\Column(length: 100)]
    private ?string $orderBilling = null;

    #[ORM\Column(length: 50)]
    private ?string $orderStatus = null;

    #[ORM\OneToOne(mappedBy: 'paymentOrder', cascade: ['persist', 'remove'])]
    private ?Payment $payment = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'detailOrder', targetEntity: OrderDetails::class)]
    private Collection $orderDetails;

    #[ORM\OneToMany(mappedBy: 'deliveryOrder', targetEntity: Delivery::class)]
    private Collection $deliveries;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTime $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOrderDelivery(): ?string
    {
        return $this->orderDelivery;
    }

    public function setOrderDelivery(string $orderDelivery): static
    {
        $this->orderDelivery = $orderDelivery;

        return $this;
    }

    public function getOrderBilling(): ?string
    {
        return $this->orderBilling;
    }

    public function setOrderBilling(string $orderBilling): static
    {
        $this->orderBilling = $orderBilling;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): static
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): static
    {
        // set the owning side of the relation if necessary
        if ($payment->getPaymentOrder() !== $this) {
            $payment->setPaymentOrder($this);
        }

        $this->payment = $payment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setDetailOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getDetailOrder() === $this) {
                $orderDetail->setDetailOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->setDeliveryOrder($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getDeliveryOrder() === $this) {
                $delivery->setDeliveryOrder(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
        // TODO: Implement __toString() method.
    }
}

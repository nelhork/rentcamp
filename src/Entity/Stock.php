<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'give_stock_id')]
    private Collection $giving_orders;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'take_stock_id')]
    private Collection $taking_orders;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'stock_id')]
    private Collection $order_items;

    /**
     * @var Collection<int, Movement>
     */
    #[ORM\OneToMany(targetEntity: Movement::class, mappedBy: 'from_stock_id', orphanRemoval: true)]
    private Collection $item_movements;

    /**
     * @var Collection<int, Movement>
     */
    #[ORM\OneToMany(targetEntity: Movement::class, mappedBy: 'to_stock_id', orphanRemoval: true)]
    private Collection $item_movements_to;

    public function __construct()
    {
        $this->giving_orders = new ArrayCollection();
        $this->taking_orders = new ArrayCollection();
        $this->order_items = new ArrayCollection();
        $this->item_movements = new ArrayCollection();
        $this->item_movements_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getGivingOrders(): Collection
    {
        return $this->giving_orders;
    }

    public function addGivingOrder(Order $givingOrder): static
    {
        if (!$this->giving_orders->contains($givingOrder)) {
            $this->giving_orders->add($givingOrder);
            $givingOrder->setGiveStockId($this);
        }

        return $this;
    }

    public function removeGivingOrder(Order $givingOrder): static
    {
        if ($this->giving_orders->removeElement($givingOrder)) {
            // set the owning side to null (unless already changed)
            if ($givingOrder->getGiveStockId() === $this) {
                $givingOrder->setGiveStockId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getTakingOrders(): Collection
    {
        return $this->taking_orders;
    }

    public function addTakingOrder(Order $takingOrder): static
    {
        if (!$this->taking_orders->contains($takingOrder)) {
            $this->taking_orders->add($takingOrder);
            $takingOrder->setTakeStockId($this);
        }

        return $this;
    }

    public function removeTakingOrder(Order $takingOrder): static
    {
        if ($this->taking_orders->removeElement($takingOrder)) {
            // set the owning side to null (unless already changed)
            if ($takingOrder->getTakeStockId() === $this) {
                $takingOrder->setTakeStockId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getOrderItems(): Collection
    {
        return $this->order_items;
    }

    public function addOrderItem(Item $orderItem): static
    {
        if (!$this->order_items->contains($orderItem)) {
            $this->order_items->add($orderItem);
            $orderItem->setStockId($this);
        }

        return $this;
    }

    public function removeOrderItem(Item $orderItem): static
    {
        if ($this->order_items->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getStockId() === $this) {
                $orderItem->setStockId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getItemMovements(): Collection
    {
        return $this->item_movements;
    }

    public function addItemMovement(Movement $itemMovement): static
    {
        if (!$this->item_movements->contains($itemMovement)) {
            $this->item_movements->add($itemMovement);
            $itemMovement->setFromStockId($this);
        }

        return $this;
    }

    public function removeItemMovement(Movement $itemMovement): static
    {
        if ($this->item_movements->removeElement($itemMovement)) {
            // set the owning side to null (unless already changed)
            if ($itemMovement->getFromStockId() === $this) {
                $itemMovement->setFromStockId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getItemMovementsTo(): Collection
    {
        return $this->item_movements_to;
    }

    public function addItemMovementsTo(Movement $itemMovementsTo): static
    {
        if (!$this->item_movements_to->contains($itemMovementsTo)) {
            $this->item_movements_to->add($itemMovementsTo);
            $itemMovementsTo->setToStockId($this);
        }

        return $this;
    }

    public function removeItemMovementsTo(Movement $itemMovementsTo): static
    {
        if ($this->item_movements_to->removeElement($itemMovementsTo)) {
            // set the owning side to null (unless already changed)
            if ($itemMovementsTo->getToStockId() === $this) {
                $itemMovementsTo->setToStockId(null);
            }
        }

        return $this;
    }
}

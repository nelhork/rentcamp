<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'order_status', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $begin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_address_to = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_address_from = null;

    #[ORM\Column]
    private ?float $delivery_price = null;

    #[ORM\Column]
    private ?float $total_amount = null;

    #[ORM\Column]
    private ?float $total_deposit = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $giver = null;

    #[ORM\ManyToOne(inversedBy: 'taking_orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $taker = null;

    #[ORM\ManyToOne(inversedBy: 'giving_orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $give_stock = null;

    #[ORM\ManyToOne(inversedBy: 'taking_orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $take_stock = null;

    #[ORM\OneToMany(targetEntity: ModelsToOrders::class, mappedBy: 'orderRef')]
    private Collection $modelsToOrders;

    public function __construct()
    {
        $this->modelsToOrders = new ArrayCollection();
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

    public function getStatusId(): ?Status
    {
        return $this->status_id;
    }

    public function setStatusId(Status $status_id): static
    {
        $this->status_id = $status_id;

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

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): static
    {
        $this->client_id = $client_id;

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

    public function getBegin(): ?\DateTimeInterface
    {
        return $this->begin;
    }

    public function setBegin(\DateTimeInterface $begin): static
    {
        $this->begin = $begin;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getDeliveryAddressTo(): ?string
    {
        return $this->delivery_address_to;
    }

    public function setDeliveryAddressTo(string $delivery_address_to): static
    {
        $this->delivery_address_to = $delivery_address_to;

        return $this;
    }

    public function getDeliveryAddressFrom(): ?string
    {
        return $this->delivery_address_from;
    }

    public function setDeliveryAddressFrom(string $delivery_address_from): static
    {
        $this->delivery_address_from = $delivery_address_from;

        return $this;
    }

    public function getDeliveryPrice(): ?float
    {
        return $this->delivery_price;
    }

    public function setDeliveryPrice(float $delivery_price): static
    {
        $this->delivery_price = $delivery_price;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->total_amount;
    }

    public function setTotalAmount(float $total_amount): static
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getTotalDeposit(): ?float
    {
        return $this->total_deposit;
    }

    public function setTotalDeposit(float $total_deposit): static
    {
        $this->total_deposit = $total_deposit;

        return $this;
    }

    public function getGiverId(): ?Employee
    {
        return $this->giver_id;
    }

    public function setGiverId(?Employee $giver_id): static
    {
        $this->giver_id = $giver_id;

        return $this;
    }

    public function getTakerId(): ?Employee
    {
        return $this->taker_id;
    }

    public function setTakerId(?Employee $taker_id): static
    {
        $this->taker_id = $taker_id;

        return $this;
    }

    public function getGiveStockId(): ?Stock
    {
        return $this->give_stock_id;
    }

    public function setGiveStockId(?Stock $give_stock_id): static
    {
        $this->give_stock_id = $give_stock_id;

        return $this;
    }

    public function getTakeStockId(): ?Stock
    {
        return $this->take_stock_id;
    }

    public function setTakeStockId(?Stock $take_stock_id): static
    {
        $this->take_stock_id = $take_stock_id;

        return $this;
    }

    public function getModelsToOrders(): Collection
    {
        return $this->modelsToOrders;
    }

    public function addModelsToOrder(ModelsToOrders $modelsToOrder): static
    {
        if (!$this->modelsToOrders->contains($modelsToOrder))
        {
            $this->modelsToOrders->add($modelsToOrder);
            $modelsToOrder->setOrderRef($this);
        }

        return $this;
    }

    public function removeModelsToOrder(ModelsToOrders $modelsToOrder): static
    {
        if ($this->modelsToOrders->removeElement($modelsToOrder))
        {
            if ($modelsToOrder->getOrderRef() === $this)
            {
                $modelsToOrder->setOrderRef(null);
            }
        }

        return $this;
    }
}

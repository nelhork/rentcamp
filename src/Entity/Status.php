<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'status_id', cascade: ['persist', 'remove'])]
    private ?Order $order_status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getOrderStatus(): ?Order
    {
        return $this->order_status;
    }

    public function setOrderStatus(Order $order_status): static
    {
        // set the owning side of the relation if necessary
        if ($order_status->getStatusId() !== $this) {
            $order_status->setStatusId($this);
        }

        $this->order_status = $order_status;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ModelsToOrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelsToOrdersRepository::class)]
#[ORM\Table(name: 'models_to_orders')]
class ModelsToOrders
{
    #[ORM\Id]
    #[ORM\Column(name: 'order_id')]
    private int $orderId;

    #[ORM\Id]
    #[ORM\Column(name: 'model_id')]
    private int $modelId;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Model::class)]
    #[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id', nullable: false)]
    private ?Model $model = null;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): static
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): static
    {
        $this->modelId = $modelId;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        if ($order)
        {
            $this->orderId = $order->getId();
        }

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        if ($model)
        {
            $this->modelId = $model->getId();
        }

        return $this;
    }
}

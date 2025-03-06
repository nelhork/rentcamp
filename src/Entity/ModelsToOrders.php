<?php

namespace App\Entity;

use App\Repository\ModelsToOrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelsToOrdersRepository::class)]
#[ORM\Table(name: 'models_to_orders')]
class ModelsToOrders
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'modelsToOrders')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    private ?Order $orderRef = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Model::class, inversedBy: 'modelsToOrders')]
    #[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id', nullable: false)]
    private ?Model $modelRef = null;

    public function getOrderRef(): ?Order
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Order $orderRef): static
    {
        $this->orderRef = $orderRef;
        return $this;
    }

    public function getModelRef(): ?Model
    {
        return $this->modelRef;
    }

    public function setModelRef(?Model $modelRef): static
    {
        $this->modelRef = $modelRef;
        return $this;
    }
}

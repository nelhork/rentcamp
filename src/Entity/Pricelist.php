<?php

namespace App\Entity;

use App\Repository\PricelistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricelistRepository::class)]
class Pricelist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Model::class)]
    #[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id', nullable: false)]
    private ?Model $model = null;

    #[ORM\Column]
    private ?float $price_for_period = null;

    #[ORM\Column]
    private ?float $deposit_for_period = null;

    #[ORM\Column]
    private ?float $full_price_for_period = null;

    #[ORM\Column]
    private ?float $period_min = null;

    #[ORM\Column]
    private ?float $period_max = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getPriceForPeriod(): ?float
    {
        return $this->price_for_period;
    }

    public function setPriceForPeriod(float $price_for_period): static
    {
        $this->price_for_period = $price_for_period;

        return $this;
    }

    public function getDepositForPeriod(): ?float
    {
        return $this->deposit_for_period;
    }

    public function setDepositForPeriod(float $deposit_for_period): static
    {
        $this->deposit_for_period = $deposit_for_period;

        return $this;
    }

    public function getFullPriceForPeriod(): ?float
    {
        return $this->full_price_for_period;
    }

    public function setFullPriceForPeriod(float $full_price_for_period): static
    {
        $this->full_price_for_period = $full_price_for_period;

        return $this;
    }

    public function getPeriodMin(): ?float
    {
        return $this->period_min;
    }

    public function setPeriodMin(float $period_min): static
    {
        $this->period_min = $period_min;

        return $this;
    }

    public function getPeriodMax(): ?float
    {
        return $this->period_max;
    }

    public function setPeriodMax(float $period_max): static
    {
        $this->period_max = $period_max;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $photo1 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 255)]
    private ?string $video1 = null;

    #[ORM\Column(length: 255)]
    private ?string $video2 = null;

    #[ORM\Column(length: 255)]
    private ?string $video3 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description1 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description3 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    /**
     * @var Collection<int, Pricelist>
     */
    #[ORM\OneToMany(targetEntity: Pricelist::class, mappedBy: 'model_id', orphanRemoval: true)]
    private Collection $pricelists;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'model_id')]
    private Collection $order_items;

    #[ORM\ManyToMany(targetEntity: Order::class, inversedBy: 'models')]
    #[ORM\JoinTable(name: 'models_to_orders')]
    private Collection $orders;

    public function __construct()
    {
        $this->pricelists = new ArrayCollection();
        $this->order_items = new ArrayCollection();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPhoto1(): ?string
    {
        return $this->photo1;
    }

    public function setPhoto1(string $photo1): static
    {
        $this->photo1 = $photo1;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(string $photo2): static
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(string $photo3): static
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getVideo1(): ?string
    {
        return $this->video1;
    }

    public function setVideo1(string $video1): static
    {
        $this->video1 = $video1;

        return $this;
    }

    public function getVideo2(): ?string
    {
        return $this->video2;
    }

    public function setVideo2(string $video2): static
    {
        $this->video2 = $video2;

        return $this;
    }

    public function getVideo3(): ?string
    {
        return $this->video3;
    }

    public function setVideo3(string $video3): static
    {
        $this->video3 = $video3;

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(string $description1): static
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(string $description2): static
    {
        $this->description2 = $description2;

        return $this;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(string $description3): static
    {
        $this->description3 = $description3;

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

    /**
     * @return Collection<int, Pricelist>
     */
    public function getPricelists(): Collection
    {
        return $this->pricelists;
    }

    public function addPricelist(Pricelist $pricelist): static
    {
        if (!$this->pricelists->contains($pricelist)) {
            $this->pricelists->add($pricelist);
            $pricelist->setModelId($this);
        }

        return $this;
    }

    public function removePricelist(Pricelist $pricelist): static
    {
        if ($this->pricelists->removeElement($pricelist)) {
            // set the owning side to null (unless already changed)
            if ($pricelist->getModelId() === $this) {
                $pricelist->setModelId(null);
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
            $orderItem->setModelId($this);
        }

        return $this;
    }

    public function removeOrderItem(Item $orderItem): static
    {
        if ($this->order_items->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getModelId() === $this) {
                $orderItem->setModelId(null);
            }
        }

        return $this;
    }
}

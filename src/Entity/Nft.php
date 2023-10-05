<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $ceatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $pict = null;

    #[ORM\Column(length: 255)]
    private ?string $creator = null;

    #[ORM\ManyToOne(targetEntity : Collecs::class, inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collecs $collec = null;

    #[ORM\OneToMany(mappedBy: 'nft', targetEntity: History::class, orphanRemoval: true)]
    private Collection $histories;
    public function __toString()
    {
        return $this->title;
    }
    public function __construct()
    {
        $this->histories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCeatedAt(): ?\DateTimeImmutable
    {
        return $this->ceatedAt;
    }

    public function setCeatedAt(\DateTimeImmutable $ceatedAt): static
    {
        $this->ceatedAt = $ceatedAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPict(): ?string
    {
        return $this->pict;
    }

    public function setPict(string $pict): static
    {
        $this->pict = $pict;

        return $this;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCollec(): ?Collecs
    {
        return $this->collec;
    }

    public function setCollec(?Collecs $collec): self
    {
        $this->collec = $collec;

        return $this;
    }

    /**
     * @return Collection<int, History>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): static
    {
        if (!$this->histories->contains($history)) {
            $this->histories->add($history);
            $history->setNft($this);
        }

        return $this;
    }

    public function removeHistory(History $history): static
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getNft() === $this) {
                $history->setNft(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource]
#[Vich\Uploadable]
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
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    // #[ORM\Column(length: 255)]
    // #[Assert\Image(
    //     minWidth: 50,
    //     maxWidth: 3000,
    //     minHeight: 50,
    //     maxHeight: 3000,
    // )]
    // private ?string $pict = null;

    #[Vich\UploadableField(mapping: 'nft', fileNameProperty: 'imageName', size: 'imageSize', nullable: false)]
    #[Assert\Image(
        minWidth: 50,
        maxWidth: 3000,
        minHeight: 50,
        maxHeight: 3000,
    )]
    private ?File $pict = null;

    #[ORM\Column(length: 255)]
    private ?string $creator = null;

    #[ORM\ManyToOne(targetEntity : Collecs::class, inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collecs $collec = null;

    #[ORM\OneToMany(mappedBy: 'nft', targetEntity: History::class, orphanRemoval: true)]
    private Collection $histories;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
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

    public function getcreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getPict(): ?File
    {
        return $this->pict;
    }
    public function setPict(?File $pict = null): void
    {
        $this->pict = $pict;

        if (null !== $pict) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

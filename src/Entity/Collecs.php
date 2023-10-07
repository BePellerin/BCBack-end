<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollecsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
// use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;
// use ApiPlatform\Core\Annotation\ApiProperty;

#[ORM\Entity(repositoryClass: CollecsRepository::class)]
#[ApiResource]
#[Vich\Uploadable]
class Collecs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $coverPict = null;

    #[Vich\UploadableField(mapping: 'coverPict', fileNameProperty: 'imageName', size:'imageSize', nullable: true)]
    private ?File $coverPict = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // #[Assert\Image(
    //     minWidth: 300,
    //     maxWidth: 1000,
    //     minHeight: 300,
    //     maxHeight: 1000,
    // )]
    // private ?string $avatarPict = null;

    #[Vich\UploadableField(mapping: 'avatarPict', fileNameProperty: 'imageName', size: 'imageSize', nullable: false)]
    #[Assert\Image(
        minWidth: 200,
        maxWidth: 1000,
        minHeight: 200,
        maxHeight: 1000,
    )]
    private ?File $avatarPict = null;

    #[ORM\Column(length: 255)]
    private ?string $blockchain = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $websiteUrl = null;

    #[ORM\OneToMany(mappedBy: 'collec', targetEntity: Nft::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $nfts;

    #[ORM\ManyToOne(inversedBy: 'collecs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'collecs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __toString()
    {
        return $this->title;
    }
    
    public function __construct()
    {
        $this->nfts = new ArrayCollection();
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setCoverPict(?File $coverPict = null): void
    {
        $this->coverPict = $coverPict;
    }

    public function getCoverPict(): ?File
    {
        return $this->coverPict;
    }

    public function setAvatarPict(?File $avatarPict = null): void
    {
        $this->avatarPict = $avatarPict;

        if (null !== $avatarPict) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getAvatarPict(): ?File
    {
        return $this->avatarPict;
    }

    public function getBlockchain(): ?string
    {
        return $this->blockchain;
    }

    public function setBlockchain(string $blockchain): static
    {
        $this->blockchain = $blockchain;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): static
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(Nft $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setCollec($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getCollec() === $this) {
                $nft->setCollec(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

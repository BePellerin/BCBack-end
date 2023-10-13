<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CollecsRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
// use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;
// use ApiPlatform\Core\Annotation\ApiProperty;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: CollecsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    paginationItemsPerPage: 25,
    paginationMaximumItemsPerPage: 25,
    paginationClientItemsPerPage: true
)]
#[Get()]
#[GetCollection()]
#[Post(
    denormalizationContext: [
        'groups' => ['write'],
        // 'disable_type_enforcement' => true,
        'collect_denormalization_errors' => true
    ],
    inputFormats: ['multipart' => ['multipart/form-data']]
)]
#[Put()]
#[Delete()]
#[Patch()]
class Collecs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Le minimum est de 1 caractères',
        maxMessage: 'Le maximum est de 50 caractères'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 1500)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 200,
        max: 1500,
        minMessage: 'Le minimum est de 200 caractères',
        maxMessage: 'Le maximum est de 1500 caractères'
    )]
    private ?string $description = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    private ?string $blockchain = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $websiteUrl = null;

    #[ORM\OneToMany(mappedBy: 'collec', targetEntity: Nft::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read', 'write'])]
    private Collection $nfts;

    #[ORM\ManyToOne(inversedBy: 'collecs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Category $category = null;

    #[ORM\Column]
    // (type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])
    // #[Assert\DateTime(format: DateTime::ATOM, message: "Enable time is not a valid datetime.")]
    // #[Assert\DateTime]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'collecs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?User $user = null;

    #[Vich\UploadableField(mapping: 'avatarPict', fileNameProperty: 'imageNameAvatar')]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '3m',
        extensions: ['jpg', 'png'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 3 MB',
    )]
    #[Assert\Image(
        minWidth: 100,
        maxWidth: 1500,
        minHeight: 100,
        maxHeight: 1500,
        minWidthMessage: "La largeur de l'image doit être au moins de 100 pixels",
        maxWidthMessage: "La largeur de l'image ne peut pas dépasser 1500 pixels",
        minHeightMessage: "La hauteur de l'image doit être au moins de 100 pixels",
        maxHeightMessage: "La hauteur de l'image ne peut pas dépasser 1500 pixels"
    )]
    private ?File $avatarPict = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $imageNameAvatar = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $updatedAtAvatar = null;


    #[Vich\UploadableField(mapping: 'coverPict', fileNameProperty: 'imageNameCover')]
    #[Groups(['read', 'write'])]
    #[Assert\File(
        maxSize: '5m',
        extensions: ['jpg', 'png'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 5 MB',
    )]
    // #[Assert\Image(
    //     minWidth: 100,
    //     maxWidth: 1500,
    //     minHeight: 100,
    //     maxHeight: 1500,
    //     minWidthMessage: "La largeur de l'image doit être au moins de 100 pixels",
    //     maxWidthMessage: "La largeur de l'image ne peut pas dépasser 1500 pixels",
    //     minHeightMessage: "La hauteur de l'image doit être au moins de 100 pixels",
    //     maxHeightMessage: "La hauteur de l'image ne peut pas dépasser 1500 pixels"
    // )]
    private ?File $coverPict = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $imageNameCover = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $updatedAtCover = null;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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
    public function getUpdatedAtAvatar(): ?\DateTimeImmutable
    {
        return $this->updatedAtAvatar;
    }

    public function setUpdatedAtAvatar(?\DateTimeImmutable $updatedAtAvatar): static
    {
        $this->updatedAtAvatar  = $updatedAtAvatar;

        return $this;
    }
    public function setAvatarPict(?File $avatarPict = null): void
    {
        $this->avatarPict = $avatarPict;

        if (null !== $avatarPict) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAtAvatar = new \DateTimeImmutable();
        }
    }

    public function getAvatarPict(): ?File
    {
        return $this->avatarPict;
    }

    public function setImageNameAvatar(?string $imageNameAvatar): void
    {
        $this->imageNameAvatar = $imageNameAvatar;
    }

    public function getImageNameAvatar(): ?string
    {
        return $this->imageNameAvatar;
    }




    public function getUpdatedAtCover(): ?\DateTimeImmutable
    {
        return $this->updatedAtCover;
    }

    public function setUpdatedAtCover(?\DateTimeImmutable $updatedAtCover): static
    {
        $this->updatedAtCover  = $updatedAtCover;

        return $this;
    }
    public function setCoverPict(?File $coverPict = null): void
    {
        $this->coverPict = $coverPict;

        if (null !== $coverPict) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAtCover = new \DateTimeImmutable();
        }
    }

    public function getCoverPict(): ?File
    {
        return $this->coverPict;
    }

    public function setImageNameCover(?string $imageNameCover): void
    {
        $this->imageNameCover = $imageNameCover;
    }

    public function getImageNameCover(): ?string
    {
        return $this->imageNameCover;
    }
}

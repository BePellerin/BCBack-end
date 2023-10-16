<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiProperty;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: NftRepository::class)]

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    types: ['%kernel.project_dir%/public/images/nfts'],
    operations: [
        new GetCollection(),
        new Post(inputFormats: ['multipart' => ['multipart/form-data']])
    ],
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
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Le minimum est de 1 caractères',
        maxMessage: 'Le maximum est de 50 caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $title = null;

    #[ORM\Column(length: 750, nullable: true)]
    #[Assert\Length(
        max: 750,
        maxMessage: 'Le maximum est de 750 caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?int $price = null;

    #[Vich\UploadableField(mapping: 'nft', fileNameProperty: 'imageName')]
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '5m',
        extensions: ['jpg', 'png', 'mp3'],
        extensionsMessage: 'Merci de télécharger un fichier jpg, png ou mp3 de moins de 5 MB ',
    )]
    #[Assert\Image(
        minWidth: 50,
        maxWidth: 5000,
        minHeight: 50,
        maxHeight: 5000,
        minWidthMessage: "La largeur de l'image doit être au moins de 50 pixels",
        maxWidthMessage: "La largeur de l'image ne peut pas dépasser 5000 pixels",
        minHeightMessage: "La hauteur de l'image doit être au moins de 50 pixels",
        maxHeightMessage: "La hauteur de l'image ne peut pas dépasser 5000 pixels"
    )]
    #[Groups(['read', 'write'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $imageName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $creator = null;

    #[ORM\ManyToOne(targetEntity: Collecs::class, inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Collecs $collec = null;

    #[ORM\OneToMany(mappedBy: 'nft', targetEntity: History::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read', 'write'])]
    private Collection $histories;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['read'])]
    public ?string $contentUrl = null;

    public function __toString()
    {
        return $this->title;
    }
    public function __construct()
    {
        $this->histories = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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
}

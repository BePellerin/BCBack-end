<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AirDropRepository;
use Attribute;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model;
use App\Controller\AirDropController;

// use App\Controller\Admin\AirDropCrudController;
// use App\Controller\CreateMediaObjectAction;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AirDropRepository::class)]
#[ApiResource(

    normalizationContext: [
        'groups' => ['read'],
        // 'groups' => ['media_object:read']
    ],
    // denormalizationContext: ['groups' => ['write']],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 10,
    paginationClientItemsPerPage: true,
)]
#[Get()]
#[GetCollection()]
#[Post(
    denormalizationContext: [
        'groups' => ['write'],
        // 'disable_type_enforcement' => true,
        // 'collect_denormalization_errors' => true
    ],
    // inputFormats: ['multipart' => ['multipart/form-data']]
)]
#[Put()]
#[Delete()]
#[Patch()]
class AirDrop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?bool $status = false;

    #[ORM\Column(length: 50)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: 'Le minimum est de 5 caractères',
        maxMessage: 'Le maximum est de 20 caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 750)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 750,
        minMessage: 'Le minimum est de 10 caractères',
        maxMessage: 'Le maximum est de 750 caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private ?int $nftQuantity = 0;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private ?string $category = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private ?int $launchPrice = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $webSiteUrl = null;

    #[Vich\UploadableField(mapping: 'airDropPict', fileNameProperty: 'imageName')]
    #[Groups(['read', 'write'])]
    #[Assert\NotNull(groups: ['media_object_create'])]
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '3000k',
        extensions: ['jpg', 'png'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 3 MB',
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
    private ?File $imageFile = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['read', 'media_object:read'])]
    public ?string $contentUrl = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'],)]
    private ?string $imageName = null;

    // #[ORM\Column(nullable: true)]
    // #[Groups(['read'])]
    // private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    #[ORM\Column]
    // #[Assert\DateTime]
    // #[Assert\Regex(
    //     pattern: '/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2}$/',
    //     message: 'Le format de la date doit être dd/mm/YYYY H:i:s'
    // )]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $launchDayAt;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $twitterUrl = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $blockchain = null;


    public function __toString()
    {
        return $this->name;
        // return $this->nftQuantity;
        // return $this->launchPrice;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

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

    public function getNftQuantity(): ?int
    {
        return $this->nftQuantity;
    }

    public function setNftQuantity(int $nftQuantity): static
    {
        $this->nftQuantity = $nftQuantity;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLaunchPrice(): ?int
    {
        return $this->launchPrice;
    }

    public function setLaunchPrice(int $launchPrice): static
    {
        $this->launchPrice = $launchPrice;
        return $this;
    }

    public function getWebSiteUrl(): ?string
    {
        return $this->webSiteUrl;
    }

    public function setWebSiteUrl(?string $webSiteUrl): static
    {
        $this->webSiteUrl = $webSiteUrl;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // if (null !== $imageFile) {
        //     $this->createdAt = new \DateTimeImmutable();
        // }
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

    public function getLaunchDayAt(): ?string
    {
        return $this->launchDayAt;
    }

    public function setLaunchDayAt(\DateTimeImmutable $launchDayAt): static
    {
        $this->launchDayAt = $launchDayAt;

        return $this;
    }

    public function getTwitterUrl(): ?string
    {
        return $this->twitterUrl;
    }

    public function setTwitterUrl(?string $twitterUrl): static
    {
        $this->twitterUrl = $twitterUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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
}

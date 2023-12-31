<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AirDropRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AirDropRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    // types: ['%kernel.project_dir%/public/images/airDrops'],
    operations: [
        new Get(
            forceEager: false
            // normalizationContext: ['groups' => ['read']]
        ),
        new GetCollection(forceEager: false),
        new Patch(security: "is_granted('ROLE_ADMIN')"),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            validationContext: ['groups' => ['Default', 'read']],
            denormalizationContext: [
                'groups' => ['write'],
                'disable_type_enforcement' => true,
                'collect_denormalization_errors' => true

            ],
        ),
        new Delete(
            // security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    // paginationItemsPerPage: 10,
    // paginationMaximumItemsPerPage: 10,
    // paginationClientItemsPerPage: true,
)]
class AirDrop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?bool $status = false;

    #[ORM\Column(length: 20)]
    #[Groups(['read', 'write'])]
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: 'Le minimum est de 5 caractères',
        maxMessage: 'Le maximum est de 20 caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 750)]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: 'Le minimum est de 10 caractères',
        maxMessage: 'Le maximum est de 150 caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $nftQuantity = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $category = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $launchPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $webSiteUrl = null;

    #[ApiProperty(types: ['%kernel.project_dir%/public/images/airDrops'])]
    #[Groups(['read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'airDropPict', fileNameProperty: 'imageName')]
    #[Assert\File(
        maxSize: '3m',
        extensions: ['jpg', 'png', 'gif', 'jpeg'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 3 MB',
    )]
    // #[Assert\Image(
    //     minWidth: 50,
    //     maxWidth: 5000,
    //     minHeight: 50,
    //     maxHeight: 5000,
    //     minWidthMessage: "La largeur de l'image doit être au moins de 50 pixels",
    //     maxWidthMessage: "La largeur de l'image ne peut pas dépasser 5000 pixels",
    //     minHeightMessage: "La hauteur de l'image doit être au moins de 50 pixels",
    //     maxHeightMessage: "La hauteur de l'image ne peut pas dépasser 5000 pixels"
    // )]
    #[Groups(['read', 'write'])]
    private ?File $imageFile = null;


    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;



    // /**
    //  * @var string A "Y-m-d H:i:s" formatted value
    //  */

    // #[Assert\DateTime]
    // #[Assert\Regex(
    //     pattern: '/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2}$/',
    //     message: 'Le format de la date doit être dd/mm/YYYY H:i:s'
    // )]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $launchDayAt;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $twitterUrl = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $blockchain = null;

    // public function computeSlug(SluggerInterface $slugger):void{
    //     $this->slug=$slugger->slug($this);
    // }
    public function __toString()
    {
        return $this->name;
        // return $this->nftQuantity;
        // return $this->launchPrice;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();

        // if ($this->nftQuantity !== null) {
        //     $this->nftQuantity = (int) $this->nftQuantity;
        // }
        // if ($this->launchPrice !== null) {
        //     $this->launchPrice = (int) $this->launchPrice;
        // }
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

    public function getNftQuantity(): ?string
    {
        return $this->nftQuantity;
    }

    public function setNftQuantity(string $nftQuantity): static
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

    public function getLaunchPrice(): ?string
    {
        return $this->launchPrice;
    }

    public function setLaunchPrice(string $launchPrice): static
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

    public function getLaunchDayAt(): ?\DateTimeImmutable
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

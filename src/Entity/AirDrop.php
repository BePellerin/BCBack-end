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
use App\Controller\Admin\AirDropCrudController;
use App\Controller\CreateMediaObjectAction;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AirDropRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']]
)]

#[Get()]
#[GetCollection()]

#[Post(
    denormalizationContext: [
        'groups' => ['write'],
        'disable_type_enforcement' => true,
        'collect_denormalization_errors' => true
    ],
    inputFormats: ['multipart' => ['multipart/form-data']]
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

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: 'Le minimum est de {{limit}} caractères',
        maxMessage: 'Le maximum est de {{limit}} caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $nftQuantity = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $category = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $launchPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $webSiteUrl = null;

    #[Vich\UploadableField(mapping: 'airDropPict', fileNameProperty: 'imageName')]
    #[Groups(['read', 'write'])]
    #[Assert\File(
        maxSize: '3mb',
        extensions: ['jpg','png'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 3 MB',
    )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __toString()
    {
        return $this->name;
        // return $this->launchPrice;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        // if (is_string($nftQuantity)) {
        //     $nftQuantity = intval($nftQuantity);
        // }
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
        // if (is_string($launchPrice)) {
        //     $launchPrice = intval($launchPrice);
        // }
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
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
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
}

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

#[ORM\Entity(repositoryClass: AirDropRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['airDropPict:read']],
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AirDropCrudController::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'airDropPict_create']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )
        ),
        new Put(),
        new Delete(),
        new Patch(),
    ]
)]
#[Vich\Uploadable]
class AirDrop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column]
    // #[Groups(['read', 'write'])]
    private ?int $nftQuantity = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['read', 'write'])]
    private ?string $category = null;

    #[ORM\Column]
    // #[Groups(['read', 'write'])]
    private ?int $launchPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Groups(['read', 'write'])]
    private ?string $webSiteUrl = null;

    // #[ORM\Column(length: 255)]
    // private ?string $pict = null;

    #[Vich\UploadableField(mapping: 'airDropPict', fileNameProperty: 'filePath')]
    #[Assert\NotNull(groups: ['airDropPict_create'])]
    // #[Assert\File(
    //     maxSize: '5m',
    //     extensions: ['jpg'],
    //     extensionsMessage: 'Please upload a .jpg',
    // )]
    private ?File $pict = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    public function __toString()
    {
        return $this->name;
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
    public function setPict(?File $pict = null): void
    {
        $this->pict = $pict;

        // if (null !== $pict) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getPict(): ?File
    {
        return $this->pict;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }
}

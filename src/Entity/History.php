<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ApiResource()]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: [
        'groups' => ['write']
    ],
    // types: ['%kernel.project_dir%/public/images/users'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            denormalizationContext: [
                'groups' => ['write'],
                'disable_type_enforcement' => true,
                'collect_denormalization_errors' => true
            ],
            validationContext: ['groups' => ['write']],
            processor: UserPasswordHasher::class,
            inputFormats: ['multipart' => ['multipart/form-data'], 'json' => ['application/json']],
        )
    ],
)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sellerName = null;

    #[ORM\Column(length: 255)]
    private ?string $buyerName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ApiProperty(fetchEager: true)]
    #[ORM\ManyToOne(inversedBy: 'histories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellerName(): ?string
    {
        return $this->sellerName;
    }

    public function setSellerName(?string $sellerName): static
    {
        $this->sellerName = $sellerName;

        return $this;
    }

    public function getBuyerName(): ?string
    {
        return $this->buyerName;
    }

    public function setBuyerName(string $buyerName): static
    {
        $this->buyerName = $buyerName;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getNft(): ?Nft
    {
        return $this->nft;
    }

    public function setNft(?Nft $nft): static
    {
        $this->nft = $nft;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\State\UserPasswordHasher;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: [
        'groups' => ['write']
    ],
    // types: ['%kernel.project_dir%/public/images/users'],
    operations: [
        new Get(forceEager: false),
        new GetCollection(forceEager: false),
        new Delete(
            // security: "is_granted('ROLE_USER')"
            // security: "is_granted('ROLE_ADMIN','ROLE_USER')"
        ),
        new Post(
            denormalizationContext: [
                'groups' => ['write'],
                'disable_type_enforcement' => true,
                'collect_denormalization_errors' => true
            ],
            validationContext: ['groups' => ['write']],
            processor: UserPasswordHasher::class,
            inputFormats: ['multipart' => ['multipart/form-data'], 'json' => ['application/json']],
        ),
        new Post(
            uriTemplate: '/users/{id}',
            denormalizationContext: [
                'groups' => ['write'],
                'disable_type_enforcement' => true,
                'collect_denormalization_errors' => true
            ],
            validationContext: ['groups' => ['write']],
            processor: UserPasswordHasher::class,
            inputFormats: ['multipart' => ['multipart/form-data']],
        ),
    ],
    // paginationItemsPerPage: 20,
    // paginationMaximumItemsPerPage: 20,
    // paginationClientItemsPerPage: true
)]
#[ApiFilter(SearchFilter::class, properties: ['username' => 'start'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Cette Email n\'est pas valide.',
    )]
    #[Groups(['read', 'write'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        minMessage: 'Votre mot de passe doit contenir au moins 10 caractères',
    )]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/",
        message: "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial (@, $, !, %, *, ?, &)"
    )]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['write'])]
    private ?string $clearPassword = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 25,
        minMessage: 'Le minimum est de 5 caractères',
        maxMessage: 'Le maximum est de 25 caractères'
    )]
    #[Groups(['read', 'write'])]
    private ?string $username = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['read', 'write'])]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Le maximum est de 50 caractères'
    )]
    private ?string $walletAdress = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?bool $status = true;

    #[ORM\Column(nullable: true, type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $decription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $twitterUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $instagramUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $youtubeUrl = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Collecs::class, orphanRemoval: true)]
    #[Groups(['read', 'write'])]
    private Collection $collecs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Nft::class, orphanRemoval: true)]
    #[Groups(['read', 'write'])]
    private Collection $nfts;

    #[ApiProperty(types: ['%kernel.project_dir%/public/images/users'])]
    #[Groups(['read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'user', fileNameProperty: 'imageName')]
    #[Assert\File(
        maxSize: '3m',
        extensions: ['jpg','png', 'jpeg'],
        extensionsMessage: 'Merci de télécharger un fichier jpg ou png de moins de 3 MB ',
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
    #[Groups(['write'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $imageName = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt;

    // #[ORM\Column(type: 'json', nullable: true)]
    // private $customData;

    public function __toString()
    {
        return $this->email;
    }
    public function __construct(
        // UserPasswordHasherInterface $password
    )
    {
        // $this->password = $password;
        $this->collecs = new ArrayCollection();
        $this->nfts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        // $this->id = 0;
    }

    // public function getCustomUserInformations(): ?array
    // {
    //     // Remplacez cela par la logique permettant de récupérer les informations personnalisées de l'utilisateur
    //     return ['custom_data' => $this->customData];
    // }

    /**
     * @see UserInterface
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        // $this->password = $this->password->hashPassword($this, $password);

        return $this;
    }

    public function getClearPassword(): ?string
    {
        return $this->clearPassword;
    }

    public function setClearPassword(?string $clearPassword): self
    {
        $this->clearPassword = $clearPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getWalletAdress(): ?string
    {
        return $this->walletAdress;
    }

    public function setWalletAdress(string $walletAdress): static
    {
        $this->walletAdress = $walletAdress;

        return $this;
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


    public function getDecription(): ?string
    {
        return $this->decription;
    }

    public function setDecription(?string $decription): static
    {
        $this->decription = $decription;

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

    public function getInstagramUrl(): ?string
    {
        return $this->instagramUrl;
    }

    public function setInstagramUrl(?string $instagramUrl): static
    {
        $this->instagramUrl = $instagramUrl;

        return $this;
    }

    public function getYoutubeUrl(): ?string
    {
        return $this->youtubeUrl;
    }

    public function setYoutubeUrl(?string $youtubeUrl): static
    {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    /**
     * @return Collection<int, Collecs>
     */
    public function getCollecs(): Collection
    {
        return $this->collecs;
    }

    public function addCollec(Collecs $collec): static
    {
        if (!$this->collecs->contains($collec)) {
            $this->collecs->add($collec);
            $collec->setUser($this);
        }

        return $this;
    }

    public function removeCollec(Collecs $collec): static
    {
        if ($this->collecs->removeElement($collec)) {
            // set the owning side to null (unless already changed)
            if ($collec->getUser() === $this) {
                $collec->setUser(null);
            }
        }

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
            $nft->setUser($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getUser() === $this) {
                $nft->setUser(null);
            }
        }

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

   

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

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
}

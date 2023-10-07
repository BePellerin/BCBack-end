<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_ADMIN","ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length:255, nullable: true)]
    private ?string $walletAdress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Image(
        minWidth: 300,
        maxWidth: 1000,
        minHeight: 300,
        maxHeight: 1000,
    )]
    private ?string $avatar = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = NULL;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $decription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitterUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeUrl = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Collecs::class, orphanRemoval: true)]
    private Collection $collecs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Nft::class, orphanRemoval: true)]
    private Collection $nfts;
    public function __toString()
    {
        return $this->email;
    }
    public function __construct()
    {
        $this->collecs = new ArrayCollection();
        $this->nfts = new ArrayCollection();
    }

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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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
}

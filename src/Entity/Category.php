<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    types: ['%kernel.project_dir%/public/images/avatarPict', '%kernel.project_dir%/public/images/CoverPict'],
    operations: [
        new Get(
            // normalizationContext: ['groups' => ['read']]
        ),
        new GetCollection(),
        new Patch(security: "is_granted('ROLE_ADMIN') or object.getUser() == user"),
        new Post(
            denormalizationContext: [
                'groups' => ['write'],
                // 'disable_type_enforcement' => true,
                'collect_denormalization_errors' => true
            ],
            inputFormats: ['multipart' => ['multipart/form-data']],
            // uriTemplate: '/categories/{id}',
            // itemUriTemplate: '/categories/{id}'
        ),
        new Delete(security: "is_granted('ROLE_ADMIN') or object.getUser() == user")
    ],
    paginationItemsPerPage: 25,
    paginationMaximumItemsPerPage: 25,
    paginationClientItemsPerPage: true
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Collecs::class)]
    private Collection $collecs;
    
    public function __toString()
    {
        return $this->libelle;
    }
    public function __construct()
    {
        $this->collecs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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
            $collec->setCategory($this);
        }

        return $this;
    }

    public function removeCollec(Collecs $collec): static
    {
        if ($this->collecs->removeElement($collec)) {
            // set the owning side to null (unless already changed)
            if ($collec->getCategory() === $this) {
                $collec->setCategory(null);
            }
        }

        return $this;
    }
}

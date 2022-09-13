<?php

namespace App\Entity;

use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FranchiseRepository::class)]
class Franchise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'franchise_id', targetEntity: Salle::class, orphanRemoval: true)]
    private Collection $salles_id;

    public function __construct()
    {
        $this->salles_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSallesId(): Collection
    {
        return $this->salles_id;
    }

    public function addSallesId(Salle $sallesId): self
    {
        if (!$this->salles_id->contains($sallesId)) {
            $this->salles_id->add($sallesId);
            $sallesId->setFranchiseId($this);
        }

        return $this;
    }

    public function removeSallesId(Salle $sallesId): self
    {
        if ($this->salles_id->removeElement($sallesId)) {
            // set the owning side to null (unless already changed)
            if ($sallesId->getFranchiseId() === $this) {
                $sallesId->setFranchiseId(null);
            }
        }

        return $this;
    }
}

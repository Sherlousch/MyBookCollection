<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'membre', cascade: ['persist', 'remove'])]
    private ?Bookcollection $bookcollection = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Bookcase::class, orphanRemoval: true)]
    private Collection $bookcases;

    public function __construct()
    {
        $this->bookcases = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBookcollection(): ?Bookcollection
    {
        return $this->bookcollection;
    }

    public function setBookcollection(?Bookcollection $bookcollection): self
    {
        $this->bookcollection = $bookcollection;

        return $this;
    }

    public function __toString() 
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Bookcase>
     */
    public function getBookcases(): Collection
    {
        return $this->bookcases;
    }

    public function addBookcase(Bookcase $bookcase): self
    {
        if (!$this->bookcases->contains($bookcase)) {
            $this->bookcases->add($bookcase);
            $bookcase->setOwner($this);
        }

        return $this;
    }

    public function removeBookcase(Bookcase $bookcase): self
    {
        if ($this->bookcases->removeElement($bookcase)) {
            // set the owning side to null (unless already changed)
            if ($bookcase->getOwner() === $this) {
                $bookcase->setOwner(null);
            }
        }

        return $this;
    }
}

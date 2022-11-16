<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subgenres', cascade: ['persist', 'remove'])]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private Collection $subgenres;

    public function __construct()
    {
        $this->subgenres = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubgenres(): Collection
    {
        return $this->subgenres;
    }

    public function addSubgenre(self $subgenre): self
    {
        if (!$this->subgenres->contains($subgenre)) {
            $this->subgenres->add($subgenre);
            $subgenre->setParent($this);
        }

        return $this;
    }

    public function removeSubgenre(self $subgenre): self
    {
        if ($this->subgenres->removeElement($subgenre)) {
            // set the owning side to null (unless already changed)
            if ($subgenre->getParent() === $this) {
                $subgenre->setParent(null);
            }
        }

        return $this;
    }

    public function __toString() 
    {
        return $this->name;
    }
}

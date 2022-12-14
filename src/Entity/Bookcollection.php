<?php

namespace App\Entity;

use App\Repository\BookcollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookcollectionRepository::class)]
class Bookcollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'collection', targetEntity: Book::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $books;

    #[ORM\OneToOne(mappedBy: 'bookcollection', cascade: ['persist', 'remove'])]
    private ?Membre $membre = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setCollection($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getCollection() === $this) {
                $book->setCollection(null);
            }
        }

        return $this;
    }

    public function __toString() 
    {
        return $this->description;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        // unset the owning side of the relation if necessary
        if ($membre === null && $this->membre !== null) {
            $this->membre->setBookcollection(null);
        }

        // set the owning side of the relation if necessary
        if ($membre !== null && $membre->getBookcollection() !== $this) {
            $membre->setBookcollection($this);
        }

        $this->membre = $membre;

        return $this;
    }
}

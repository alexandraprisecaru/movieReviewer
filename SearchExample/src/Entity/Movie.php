<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $trailer;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Actor", mappedBy="idMovie")
     */
    private $idActor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="idMovie", orphanRemoval=true)
     */
    private $reviews;

    public function __construct()
    {
        $this->idActor = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getTrailer(): ?string
    {
        return $this->trailer;
    }

    public function setTrailer(?string $trailer): self
    {
        $this->trailer = $trailer;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getIdActor(): Collection
    {
        return $this->idActor;
    }

    public function addIdActor(Actor $idActor): self
    {
        if (!$this->idActor->contains($idActor)) {
            $this->idActor[] = $idActor;
            $idActor->addIdMovie($this);
        }

        return $this;
    }

    public function removeIdActor(Actor $idActor): self
    {
        if ($this->idActor->contains($idActor)) {
            $this->idActor->removeElement($idActor);
            $idActor->removeIdMovie($this);
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setIdMovie($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getIdMovie() === $this) {
                $review->setIdMovie(null);
            }
        }

        return $this;
    }

    public function __toString() {
        try {
            return (string) $this->title;
        } catch (Exception $exception) {
            return '';
        }
    }

    public function getNameSuggest(){
        return $this->title;
    }
}

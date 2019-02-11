<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idMovie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserReview", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getIdMovie(): ?Movie
    {
        return $this->idMovie;
    }

    public function setIdMovie(?Movie $idMovie): self
    {
        $this->idMovie = $idMovie;

        return $this;
    }

    public function getIdUser(): ?UserReview
    {
        return $this->idUser;
    }

    public function setIdUser(?UserReview $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function __toString() {
        try {
            return (string) $this->title;
        } catch (Exception $exception) {
            return '';
        }
    }
}

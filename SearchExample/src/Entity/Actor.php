<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="idActor")
     */
    private $idMovie;

    public function __construct()
    {
        $this->idMovie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    /**
     * @return Collection|Movie[]
     */
    public function getIdMovie(): Collection
    {
        return $this->idMovie;
    }

    public function addIdMovie(Movie $idMovie): self
    {
        if (!$this->idMovie->contains($idMovie)) {
            $this->idMovie[] = $idMovie;
        }

        return $this;
    }

    public function removeIdMovie(Movie $idMovie): self
    {
        if ($this->idMovie->contains($idMovie)) {
            $this->idMovie->removeElement($idMovie);
        }

        return $this;
    }

    public function __toString() {
        try {
            return (string) $this->firstName . ' ' . $this->lastName;
        } catch (Exception $exception) {
            return '';
        }
    }
}

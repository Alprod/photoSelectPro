<?php

namespace App\Entity;

use App\Repository\BinomialPreSelectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BinomialPreSelectionRepository::class)]
class BinomialPreSelection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'binomialPreSelections')]
    private ?Binomial $binomial = null;

    #[ORM\ManyToMany(targetEntity: Photo::class, inversedBy: 'binomialPreSelections')]
    private Collection $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBinomial(): ?Binomial
    {
        return $this->binomial;
    }

    public function setBinomial(?Binomial $binomial): static
    {
        $this->binomial = $binomial;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        $this->photos->removeElement($photo);

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\BinomialPreSelectionRepository;
use App\Trait\ResourceId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BinomialPreSelectionRepository::class)]
class BinomialPreSelection
{
    use ResourceId;

    #[ORM\ManyToOne(inversedBy: 'binomialPreSelections')]
    private ?Binomial $binomial = null;

    #[ORM\ManyToMany(targetEntity: Photo::class, inversedBy: 'binomialPreSelections')]
    private Collection $photos;

    #[ORM\ManyToMany(targetEntity: BinomialFinalSelection::class, mappedBy: 'selectedPhoto')]
    private Collection $binomialFinalSelections;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->binomialFinalSelections = new ArrayCollection();
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

    /**
     * @return Collection<int, BinomialFinalSelection>
     */
    public function getBinomialFinalSelections(): Collection
    {
        return $this->binomialFinalSelections;
    }

    public function addBinomialFinalSelection(BinomialFinalSelection $binomialFinalSelection): static
    {
        if (!$this->binomialFinalSelections->contains($binomialFinalSelection)) {
            $this->binomialFinalSelections->add($binomialFinalSelection);
            $binomialFinalSelection->addSelectedPhoto($this);
        }

        return $this;
    }

    public function removeBinomialFinalSelection(BinomialFinalSelection $binomialFinalSelection): static
    {
        if ($this->binomialFinalSelections->removeElement($binomialFinalSelection)) {
            $binomialFinalSelection->removeSelectedPhoto($this);
        }

        return $this;
    }
}

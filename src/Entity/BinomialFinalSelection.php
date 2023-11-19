<?php

namespace App\Entity;

use App\Repository\BinomialFinalSelectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BinomialFinalSelectionRepository::class)]
class BinomialFinalSelection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'binomialFinalSelections')]
    private ?Binomial $binomial = null;

    #[ORM\ManyToMany(targetEntity: BinomialPreSelection::class, inversedBy: 'binomialFinalSelections')]
    private Collection $selectedPhoto;

    public function __construct()
    {
        $this->selectedPhoto = new ArrayCollection();
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
     * @return Collection<int, BinomialPreSelection>
     */
    public function getSelectedPhoto(): Collection
    {
        return $this->selectedPhoto;
    }

    public function addSelectedPhoto(BinomialPreSelection $selectedPhoto): static
    {
        if (!$this->selectedPhoto->contains($selectedPhoto)) {
            $this->selectedPhoto->add($selectedPhoto);
        }

        return $this;
    }

    public function removeSelectedPhoto(BinomialPreSelection $selectedPhoto): static
    {
        $this->selectedPhoto->removeElement($selectedPhoto);

        return $this;
    }
}

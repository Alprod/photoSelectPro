<?php

namespace App\Entity;

use App\Repository\BinomialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BinomialRepository::class)]
class Binomial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'firstBinomials')]
    private ?User $firstUser = null;

    #[ORM\ManyToOne(inversedBy: 'secondBinomials')]
    private ?User $secondUser = null;

    #[ORM\ManyToOne(inversedBy: 'binomials')]
    private ?Group $groupUser = null;

    #[ORM\OneToMany(mappedBy: 'binomial', targetEntity: BinomialPreSelection::class)]
    private Collection $binomialPreSelections;

    #[ORM\OneToMany(mappedBy: 'binomial', targetEntity: BinomialFinalSelection::class)]
    private Collection $binomialFinalSelections;

    public function __construct()
    {
        $this->binomialPreSelections = new ArrayCollection();
        $this->binomialFinalSelections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUser(): ?User
    {
        return $this->firstUser;
    }

    public function setFirstUser(?User $firstUser): static
    {
        $this->firstUser = $firstUser;

        return $this;
    }

    public function getSecondUser(): ?User
    {
        return $this->secondUser;
    }

    public function setSecondUser(?User $secondUser): static
    {
        $this->secondUser = $secondUser;

        return $this;
    }

    public function getGroupUser(): ?Group
    {
        return $this->groupUser;
    }

    public function setGroupUser(?Group $groupUser): static
    {
        $this->groupUser = $groupUser;

        return $this;
    }

    /**
     * @return Collection<int, BinomialPreSelection>
     */
    public function getBinomialPreSelections(): Collection
    {
        return $this->binomialPreSelections;
    }

    public function addBinomialPreSelection(BinomialPreSelection $binomialPreSelection): static
    {
        if (!$this->binomialPreSelections->contains($binomialPreSelection)) {
            $this->binomialPreSelections->add($binomialPreSelection);
            $binomialPreSelection->setBinomial($this);
        }

        return $this;
    }

    public function removeBinomialPreSelection(BinomialPreSelection $binomialPreSelection): static
    {
        if ($this->binomialPreSelections->removeElement($binomialPreSelection)) {
            // set the owning side to null (unless already changed)
            if ($binomialPreSelection->getBinomial() === $this) {
                $binomialPreSelection->setBinomial(null);
            }
        }

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
            $binomialFinalSelection->setBinomial($this);
        }

        return $this;
    }

    public function removeBinomialFinalSelection(BinomialFinalSelection $binomialFinalSelection): static
    {
        if ($this->binomialFinalSelections->removeElement($binomialFinalSelection)) {
            // set the owning side to null (unless already changed)
            if ($binomialFinalSelection->getBinomial() === $this) {
                $binomialFinalSelection->setBinomial(null);
            }
        }

        return $this;
    }
}

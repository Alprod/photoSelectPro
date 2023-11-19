<?php

namespace App\Entity;

use App\Repository\GroupFinalSelectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupFinalSelectionRepository::class)]
class GroupFinalSelection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'groupFinalSelections')]
    private ?Group $groupFinal = null;

    #[ORM\ManyToMany(targetEntity: BinomialFinalSelection::class, inversedBy: 'groupFinalSelections')]
    private Collection $photo;

    public function __construct()
    {
        $this->photo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupFinal(): ?Group
    {
        return $this->groupFinal;
    }

    public function setGroupFinal(?Group $groupFinal): static
    {
        $this->groupFinal = $groupFinal;

        return $this;
    }

    /**
     * @return Collection<int, BinomialFinalSelection>
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(BinomialFinalSelection $photo): static
    {
        if (!$this->photo->contains($photo)) {
            $this->photo->add($photo);
        }

        return $this;
    }

    public function removePhoto(BinomialFinalSelection $photo): static
    {
        $this->photo->removeElement($photo);

        return $this;
    }
}

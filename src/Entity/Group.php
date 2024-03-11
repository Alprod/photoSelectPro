<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use App\Trait\ResourceId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    use ResourceId;

    #[Assert\NotBlank(message: 'Veuillez indiquer un nom de groupe')]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(cascade: ['persist'],inversedBy: 'groups')]
    private ?Thematic $thematic = null;

    #[ORM\OneToMany(mappedBy: 'groupUser', targetEntity: Binomial::class)]
    private Collection $binomials;

    #[ORM\OneToMany(mappedBy: 'groupFinal', targetEntity: GroupFinalSelection::class)]
    private Collection $groupFinalSelections;

    #[Assert\GreaterThan(2)]
    #[ORM\Column]
    private ?int $maxPersonByGroup = 0;

    public function __construct()
    {
        $this->binomials = new ArrayCollection();
        $this->groupFinalSelections = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getThematic(): ?Thematic
    {
        return $this->thematic;
    }

    public function setThematic(?Thematic $thematic): static
    {
        $this->thematic = $thematic;

        return $this;
    }

    /**
     * @return Collection<int, Binomial>
     */
    public function getBinomials(): Collection
    {
        return $this->binomials;
    }

    public function addBinomial(Binomial $binomial): static
    {
        if (!$this->binomials->contains($binomial)) {
            $this->binomials->add($binomial);
            $binomial->setGroupUser($this);
        }

        return $this;
    }

    public function removeBinomial(Binomial $binomial): static
    {
        if ($this->binomials->removeElement($binomial)) {
            // set the owning side to null (unless already changed)
            if ($binomial->getGroupUser() === $this) {
                $binomial->setGroupUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupFinalSelection>
     */
    public function getGroupFinalSelections(): Collection
    {
        return $this->groupFinalSelections;
    }

    public function addGroupFinalSelection(GroupFinalSelection $groupFinalSelection): static
    {
        if (!$this->groupFinalSelections->contains($groupFinalSelection)) {
            $this->groupFinalSelections->add($groupFinalSelection);
            $groupFinalSelection->setGroupFinal($this);
        }

        return $this;
    }

    public function removeGroupFinalSelection(GroupFinalSelection $groupFinalSelection): static
    {
        if ($this->groupFinalSelections->removeElement($groupFinalSelection)) {
            // set the owning side to null (unless already changed)
            if ($groupFinalSelection->getGroupFinal() === $this) {
                $groupFinalSelection->setGroupFinal(null);
            }
        }

        return $this;
    }

    public function getMaxPersonByGroup(): ?int
    {
        return $this->maxPersonByGroup;
    }

    public function setMaxPersonByGroup(int $maxPersonByGroup): static
    {
        $this->maxPersonByGroup = $maxPersonByGroup;

        return $this;
    }
}

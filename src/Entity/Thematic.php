<?php

namespace App\Entity;

use App\Repository\ThematicRepository;
use App\Trait\ResourceId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThematicRepository::class)]
class Thematic
{
    use ResourceId;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(cascade: ['remove', 'persist'], inversedBy: 'thematics')]
    private ?SelectionProcess $selectionProcess = null;

    #[ORM\OneToMany(mappedBy: 'thematic', targetEntity: Group::class, cascade: ['persist', 'remove'])]
    private Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = htmlspecialchars($description);

        return $this;
    }

    public function getSelectionProcess(): ?SelectionProcess
    {
        return $this->selectionProcess;
    }

    public function setSelectionProcess(?SelectionProcess $selectionProcess): static
    {
        $this->selectionProcess = $selectionProcess;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): static
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->setThematic($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): static
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getThematic() === $this) {
                $group->setThematic(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'groups')]
    private ?Thematic $thematic = null;

    #[ORM\OneToMany(mappedBy: 'groupUser', targetEntity: Binomial::class)]
    private Collection $binomials;

    public function __construct()
    {
        $this->binomials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}

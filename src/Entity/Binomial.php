<?php

namespace App\Entity;

use App\Repository\BinomialRepository;
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
}

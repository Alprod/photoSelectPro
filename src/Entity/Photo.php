<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use App\Trait\ResourceId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    use ResourceId;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Client $client = null;

    #[ORM\ManyToMany(targetEntity: BinomialPreSelection::class, mappedBy: 'photos')]
    private Collection $binomialPreSelections;

    public function __construct()
    {
        $this->binomialPreSelections = new ArrayCollection();
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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
            $binomialPreSelection->addPhoto($this);
        }

        return $this;
    }

    public function removeBinomialPreSelection(BinomialPreSelection $binomialPreSelection): static
    {
        if ($this->binomialPreSelections->removeElement($binomialPreSelection)) {
            $binomialPreSelection->removePhoto($this);
        }

        return $this;
    }
}

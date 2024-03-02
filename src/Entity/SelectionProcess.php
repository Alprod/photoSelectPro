<?php

namespace App\Entity;

use App\Repository\SelectionProcessRepository;
use App\Trait\ResourceId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SelectionProcessRepository::class)]
class SelectionProcess
{
    use ResourceId;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'selectionProcesses')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'selectionProcess', targetEntity: Thematic::class, cascade: ['persist', 'remove'])]
    private Collection $thematics;

    #[ORM\OneToMany(mappedBy: 'selectionProcess', targetEntity: Photo::class)]
    private Collection $photos;

    public function __construct()
    {
        $this->thematics = new ArrayCollection();
        $this->photos = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

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
     * @return Collection<int, Thematic>
     */
    public function getThematics(): Collection
    {
        return $this->thematics;
    }

    public function addThematic(Thematic $thematic): static
    {
        if (!$this->thematics->contains($thematic)) {
            $this->thematics->add($thematic);
            $thematic->setSelectionProcess($this);
        }

        return $this;
    }

    public function removeThematic(Thematic $thematic): static
    {
        if ($this->thematics->removeElement($thematic)) {
            // set the owning side to null (unless already changed)
            if ($thematic->getSelectionProcess() === $this) {
                $thematic->setSelectionProcess(null);
            }
        }

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
            $photo->setSelectionProcess($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getSelectionProcess() === $this) {
                $photo->setSelectionProcess(null);
            }
        }

        return $this;
    }
}

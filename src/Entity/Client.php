<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use App\Trait\ResourceId;
use App\Trait\TimestampablePrePersistTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    use ResourceId;
    use TimestampablePrePersistTrait;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $refNumber = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: User::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: SelectionProcess::class)]
    private Collection $selectionProcesses;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Photo::class)]
    private Collection $photos;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->selectionProcesses = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = htmlentities($description);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): static
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getRefNumber(): ?string
    {
        return $this->refNumber;
    }

    public function setRefNumber(string $refNumber): static
    {
        $this->refNumber = $refNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SelectionProcess>
     */
    public function getSelectionProcesses(): Collection
    {
        return $this->selectionProcesses;
    }

    public function addSelectionProcess(SelectionProcess $selectionProcess): static
    {
        if (!$this->selectionProcesses->contains($selectionProcess)) {
            $this->selectionProcesses->add($selectionProcess);
            $selectionProcess->setClient($this);
        }

        return $this;
    }

    public function removeSelectionProcess(SelectionProcess $selectionProcess): static
    {
        if ($this->selectionProcesses->removeElement($selectionProcess)) {
            // set the owning side to null (unless already changed)
            if ($selectionProcess->getClient() === $this) {
                $selectionProcess->setClient(null);
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
            $photo->setClient($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getClient() === $this) {
                $photo->setClient(null);
            }
        }

        return $this;
    }
}

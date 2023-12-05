<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Nous sommes désolés, mais cette adresse e-mail est déjà enregistrée. Veuillez sélectionner une autre adresse.')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'firstUser', targetEntity: Binomial::class)]
    private Collection $firstBinomials;

    #[ORM\OneToMany(mappedBy: 'secondUser', targetEntity: Binomial::class)]
    private Collection $secondBinomials;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->firstBinomials = new ArrayCollection();
        $this->secondBinomials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
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
     * @return Collection<int, Binomial>
     */
    public function getFirstBinomials(): Collection
    {
        return $this->firstBinomials;
    }

    public function addFirstBinomial(Binomial $firstBinomial): static
    {
        if (!$this->firstBinomials->contains($firstBinomial)) {
            $this->firstBinomials->add($firstBinomial);
            $firstBinomial->setFirstUser($this);
        }

        return $this;
    }

    public function removeFirstBinomial(Binomial $firstBinomial): static
    {
        if ($this->firstBinomials->removeElement($firstBinomial)) {
            // set the owning side to null (unless already changed)
            if ($firstBinomial->getFirstUser() === $this) {
                $firstBinomial->setFirstUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Binomial>
     */
    public function getSecondBinomials(): Collection
    {
        return $this->secondBinomials;
    }

    public function addSecondBinomial(Binomial $secondBinomial): static
    {
        if (!$this->secondBinomials->contains($secondBinomial)) {
            $this->secondBinomials->add($secondBinomial);
            $secondBinomial->setSecondUser($this);
        }

        return $this;
    }

    public function removeSecondBinomial(Binomial $secondBinomial): static
    {
        if ($this->secondBinomials->removeElement($secondBinomial)) {
            // set the owning side to null (unless already changed)
            if ($secondBinomial->getSecondUser() === $this) {
                $secondBinomial->setSecondUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}

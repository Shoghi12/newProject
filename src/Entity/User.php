<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;
    #[ORM\Column(length: 180, nullable: true)]
    private ?string $googleId = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    
    #[ORM\Column(length: 180, nullable: true)]
    private ?string $name = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    /**
     * @var Collection<int, Actuality>
     */
    #[ORM\OneToMany(targetEntity: Actuality::class, mappedBy: 'userId')]
    private Collection $actualities;

    /**
     * @var Collection<int, Documentation>
     */
    #[ORM\OneToMany(targetEntity: Documentation::class, mappedBy: 'UserId')]
    private Collection $documentations;

    /**
     * @var Collection<int, Report>
     */
    #[ORM\OneToMany(targetEntity: Report::class, mappedBy: 'user_id')]
    private Collection $reports;

    public function __construct()
    {
        $this->actualities = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

      public function setGoogleId(?string $googleId): ?string
    {
        $this->googleId = $googleId;

        return $this->googleId;
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

    public function getName(): ?string
    {
        return $this->email;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
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

    /**
     * @return Collection<int, Actuality>
     */
    public function getActualities(): Collection
    {
        return $this->actualities;
    }

    public function addActuality(Actuality $actuality): static
    {
        if (!$this->actualities->contains($actuality)) {
            $this->actualities->add($actuality);
            $actuality->setUserId($this);
        }

        return $this;
    }

    public function removeActuality(Actuality $actuality): static
    {
        if ($this->actualities->removeElement($actuality)) {
            // set the owning side to null (unless already changed)
            if ($actuality->getUserId() === $this) {
                $actuality->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Documentation>
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }

    public function addDocumentation(Documentation $documentation): static
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations->add($documentation);
            $documentation->setUserId($this);
        }

        return $this;
    }

    public function removeDocumentation(Documentation $documentation): static
    {
        if ($this->documentations->removeElement($documentation)) {
            // set the owning side to null (unless already changed)
            if ($documentation->getUserId() === $this) {
                $documentation->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setUserId($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getUserId() === $this) {
                $report->setUserId(null);
            }
        }

        return $this;
    }
}

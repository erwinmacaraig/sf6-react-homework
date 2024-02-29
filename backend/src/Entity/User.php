<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $familyName = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $passwordHash = null;

    #[ORM\OneToMany(targetEntity: UserRole::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $role;

    #[ORM\OneToMany(targetEntity: UserClass::class, mappedBy: 'user')]
    private Collection $subject;

    #[ORM\OneToMany(targetEntity: UploadedFile::class, mappedBy: 'user')]
    private Collection $uploadedFiles;

    #[ORM\OneToMany(targetEntity: Homework::class, mappedBy: 'user')]
    private Collection $homework;

    #[ORM\OneToMany(targetEntity: Submission::class, mappedBy: 'user')]
    private Collection $submissions;

    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->subject = new ArrayCollection();
        $this->uploadedFiles = new ArrayCollection();
        $this->homework = new ArrayCollection();
        $this->submissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
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

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): static
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getUserIdentifier(): string
    {
        return " ";
    }

    /**
     * @return Collection<int, UserRole>
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(UserRole $role): static
    {
        if (!$this->role->contains($role)) {
            $this->role->add($role);
            $role->setUser($this);
        }

        return $this;
    }

    public function removeRole(UserRole $role): static
    {
        if ($this->role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUser() === $this) {
                $role->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserClass>
     */
    public function getSubject(): Collection
    {
        return $this->subject;
    }

    public function addSubject(UserClass $subject): static
    {
        if (!$this->subject->contains($subject)) {
            $this->subject->add($subject);
            $subject->setUser($this);
        }

        return $this;
    }

    public function removeSubject(UserClass $subject): static
    {
        if ($this->subject->removeElement($subject)) {
            // set the owning side to null (unless already changed)
            if ($subject->getUser() === $this) {
                $subject->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UploadedFile>
     */
    public function getUploadedFiles(): Collection
    {
        return $this->uploadedFiles;
    }

    public function addUploadedFile(UploadedFile $uploadedFile): static
    {
        if (!$this->uploadedFiles->contains($uploadedFile)) {
            $this->uploadedFiles->add($uploadedFile);
            $uploadedFile->setUser($this);
        }

        return $this;
    }

    public function removeUploadedFile(UploadedFile $uploadedFile): static
    {
        if ($this->uploadedFiles->removeElement($uploadedFile)) {
            // set the owning side to null (unless already changed)
            if ($uploadedFile->getUser() === $this) {
                $uploadedFile->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Homework>
     */
    public function getHomework(): Collection
    {
        return $this->homework;
    }

    public function addHomework(Homework $homework): static
    {
        if (!$this->homework->contains($homework)) {
            $this->homework->add($homework);
            $homework->setUser($this);
        }

        return $this;
    }

    public function removeHomework(Homework $homework): static
    {
        if ($this->homework->removeElement($homework)) {
            // set the owning side to null (unless already changed)
            if ($homework->getUser() === $this) {
                $homework->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Submission>
     */
    public function getSubmissions(): Collection
    {
        return $this->submissions;
    }

    public function addSubmission(Submission $submission): static
    {
        if (!$this->submissions->contains($submission)) {
            $this->submissions->add($submission);
            $submission->setUser($this);
        }

        return $this;
    }

    public function removeSubmission(Submission $submission): static
    {
        if ($this->submissions->removeElement($submission)) {
            // set the owning side to null (unless already changed)
            if ($submission->getUser() === $this) {
                $submission->setUser(null);
            }
        }

        return $this;
    }
}

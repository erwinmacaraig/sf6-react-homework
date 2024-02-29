<?php

namespace App\Entity;

use App\Repository\StudentClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentClassRepository::class)]
class StudentClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $classTitle = null;

    #[ORM\OneToMany(targetEntity: UserClass::class, mappedBy: 'studentClass')]
    private Collection $userClasses;

    #[ORM\OneToMany(targetEntity: Homework::class, mappedBy: 'studentClass')]
    private Collection $homework;

    public function __construct()
    {
        $this->userClasses = new ArrayCollection();
        $this->homework = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassTitle(): ?string
    {
        return $this->classTitle;
    }

    public function setClassTitle(string $classTitle): static
    {
        $this->classTitle = $classTitle;

        return $this;
    }

    /**
     * @return Collection<int, UserClass>
     */
    public function getUserClasses(): Collection
    {
        return $this->userClasses;
    }

    public function addUserClass(UserClass $userClass): static
    {
        if (!$this->userClasses->contains($userClass)) {
            $this->userClasses->add($userClass);
            $userClass->setStudentClass($this);
        }

        return $this;
    }

    public function removeUserClass(UserClass $userClass): static
    {
        if ($this->userClasses->removeElement($userClass)) {
            // set the owning side to null (unless already changed)
            if ($userClass->getStudentClass() === $this) {
                $userClass->setStudentClass(null);
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
            $homework->setStudentClass($this);
        }

        return $this;
    }

    public function removeHomework(Homework $homework): static
    {
        if ($this->homework->removeElement($homework)) {
            // set the owning side to null (unless already changed)
            if ($homework->getStudentClass() === $this) {
                $homework->setStudentClass(null);
            }
        }

        return $this;
    }
}

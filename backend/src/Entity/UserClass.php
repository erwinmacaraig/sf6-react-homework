<?php

namespace App\Entity;

use App\Repository\UserClassRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserClassRepository::class)]
class UserClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subject')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userClasses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentClass $studentClass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStudentClass(): ?StudentClass
    {
        return $this->studentClass;
    }

    public function setStudentClass(?StudentClass $studentClass): static
    {
        $this->studentClass = $studentClass;

        return $this;
    }
}

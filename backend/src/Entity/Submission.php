<?php

namespace App\Entity;

use App\Repository\SubmissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubmissionRepository::class)]
class Submission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSubmitted = null;

    #[ORM\ManyToOne(inversedBy: 'submissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Homework $homework = null;

    #[ORM\ManyToOne(inversedBy: 'submissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UploadedFile $uploadedFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSubmitted(): ?\DateTimeInterface
    {
        return $this->dateSubmitted;
    }

    public function setDateSubmitted(\DateTimeInterface $dateSubmitted): static
    {
        $this->dateSubmitted = $dateSubmitted;

        return $this;
    }

    public function getHomework(): ?Homework
    {
        return $this->homework;
    }

    public function setHomework(?Homework $homework): static
    {
        $this->homework = $homework;

        return $this;
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

    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(?UploadedFile $uploadedFile): static
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }
}

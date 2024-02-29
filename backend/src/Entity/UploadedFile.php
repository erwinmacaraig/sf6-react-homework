<?php

namespace App\Entity;

use App\Repository\UploadedFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UploadedFileRepository::class)]
class UploadedFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fileTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $originalFilename = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateUploaded = null;

    #[ORM\ManyToOne(inversedBy: 'uploadedFiles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileTitle(): ?string
    {
        return $this->fileTitle;
    }

    public function setFileTitle(string $fileTitle): static
    {
        $this->fileTitle = $fileTitle;

        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(string $originalFilename): static
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    public function getDateUploaded(): ?\DateTimeInterface
    {
        return $this->dateUploaded;
    }

    public function setDateUploaded(\DateTimeInterface $dateUploaded): static
    {
        $this->dateUploaded = $dateUploaded;

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
}

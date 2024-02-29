<?php

namespace App\Entity;

use App\Repository\HomeworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeworkRepository::class)]
class Homework
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $submissionDeadline = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $postedDate = null;

    #[ORM\ManyToOne(inversedBy: 'homework')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentClass $studentClass = null;

    #[ORM\ManyToOne(inversedBy: 'homework')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Submission::class, mappedBy: 'homework')]
    private Collection $submissions;

    #[ORM\Column(length: 255)]
    private ?string $homeworkTitle = null;

    public function __construct()
    {
        $this->submissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSubmissionDeadline(): ?\DateTimeInterface
    {
        return $this->submissionDeadline;
    }

    public function setSubmissionDeadline(\DateTimeInterface $submissionDeadline): static
    {
        $this->submissionDeadline = $submissionDeadline;

        return $this;
    }

    public function getPostedDate(): ?\DateTimeInterface
    {
        return $this->postedDate;
    }

    public function setPostedDate(\DateTimeInterface $postedDate): static
    {
        $this->postedDate = $postedDate;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $submission->setHomework($this);
        }

        return $this;
    }

    public function removeSubmission(Submission $submission): static
    {
        if ($this->submissions->removeElement($submission)) {
            // set the owning side to null (unless already changed)
            if ($submission->getHomework() === $this) {
                $submission->setHomework(null);
            }
        }

        return $this;
    }

    public function getHomeworkTitle(): ?string
    {
        return $this->homeworkTitle;
    }

    public function setHomeworkTitle(string $homeworkTitle): static
    {
        $this->homeworkTitle = $homeworkTitle;

        return $this;
    }
}

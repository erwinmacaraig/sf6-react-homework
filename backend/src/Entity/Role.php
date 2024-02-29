<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $roleTitle = null;

    #[ORM\OneToMany(targetEntity: UserRole::class, mappedBy: 'role')]
    private Collection $roleid;

    public function __construct()
    {
        $this->roleid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getRoleTitle(): ?string
    {
        return $this->roleTitle;
    }

    public function setRoleTitle(string $roleTitle): static
    {
        $this->roleTitle = $roleTitle;

        return $this;
    }

    /**
     * @return Collection<int, UserRole>
     */
    public function getRoleid(): Collection
    {
        return $this->roleid;
    }
}

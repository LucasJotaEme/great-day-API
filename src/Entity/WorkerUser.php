<?php

namespace App\Entity;

use App\Repository\WorkerUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkerUserRepository::class)]
class WorkerUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $workingMinutes = null;

    #[ORM\Column(nullable: true)]
    private ?float $restMinutes = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalWorkingHours = null;

    #[ORM\OneToOne(inversedBy: 'workerUser', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkingMinutes(): ?float
    {
        return $this->workingMinutes;
    }

    public function setWorkingMinutes(?float $workingMinutes): self
    {
        $this->workingMinutes = $workingMinutes;

        return $this;
    }

    public function getRestMinutes(): ?float
    {
        return $this->restMinutes;
    }

    public function setRestMinutes(?float $restMinutes): self
    {
        $this->restMinutes = $restMinutes;

        return $this;
    }

    public function getTotalWorkingHours(): ?float
    {
        return $this->totalWorkingHours;
    }

    public function setTotalWorkingHours(?float $totalWorkingHours): self
    {
        $this->totalWorkingHours = $totalWorkingHours;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

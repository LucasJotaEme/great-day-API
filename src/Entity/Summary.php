<?php

namespace App\Entity;

use App\Repository\SummaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummaryRepository::class)]
class Summary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(nullable: true)]
    private ?float $hoursWorked = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalWorkingHours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getHoursWorked(): ?float
    {
        return $this->hoursWorked;
    }

    public function setHoursWorked(?float $hoursWorked): self
    {
        $this->hoursWorked = $hoursWorked;

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
}

<?php

namespace App\Entity;

use App\Repository\SummaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'summaries')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'summary', targetEntity: SummaryDataTask::class)]
    private Collection $summaryDataTasks;

    public function __construct()
    {
        $this->summaryDataTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(): self
    {
        $creationDate = new \DateTime();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, SummaryDataTask>
     */
    public function getSummaryDataTasks(): Collection
    {
        return $this->summaryDataTasks;
    }

    public function addSummaryDataTask(SummaryDataTask $summaryDataTask): self
    {
        if (!$this->summaryDataTasks->contains($summaryDataTask)) {
            $this->summaryDataTasks->add($summaryDataTask);
            $summaryDataTask->setSummary($this);
        }

        return $this;
    }

    public function removeSummaryDataTask(SummaryDataTask $summaryDataTask): self
    {
        if ($this->summaryDataTasks->removeElement($summaryDataTask)) {
            // set the owning side to null (unless already changed)
            if ($summaryDataTask->getSummary() === $this) {
                $summaryDataTask->setSummary(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SummaryDataTaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummaryDataTaskRepository::class)]
class SummaryDataTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\ManyToOne(inversedBy: 'summaryDataTasks')]
    private ?TaskType $taskType = null;

    #[ORM\ManyToOne(inversedBy: 'summaryDataTasks')]
    private ?Summary $summary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getTaskType(): ?TaskType
    {
        return $this->taskType;
    }

    public function setTaskType(?TaskType $taskType): self
    {
        $this->taskType = $taskType;

        return $this;
    }

    public function getSummary(): ?Summary
    {
        return $this->summary;
    }

    public function setSummary(?Summary $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}

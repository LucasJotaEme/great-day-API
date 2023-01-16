<?php

namespace App\Entity;

use App\Repository\TaskTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskTypeRepository::class)]
class TaskType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\OneToMany(mappedBy: 'taskType', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'taskType', targetEntity: SummaryDataTask::class)]
    private Collection $summaryDataTasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->summaryDataTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setTaskType($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getTaskType() === $this) {
                $task->setTaskType(null);
            }
        }

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
            $summaryDataTask->setTaskType($this);
        }

        return $this;
    }

    public function removeSummaryDataTask(SummaryDataTask $summaryDataTask): self
    {
        if ($this->summaryDataTasks->removeElement($summaryDataTask)) {
            // set the owning side to null (unless already changed)
            if ($summaryDataTask->getTaskType() === $this) {
                $summaryDataTask->setTaskType(null);
            }
        }

        return $this;
    }
}

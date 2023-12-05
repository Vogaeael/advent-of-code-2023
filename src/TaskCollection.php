<?php

namespace Vogaeael\AdventOfCode2023;

use Exception;

class TaskCollection
{
    /** @var array<int, array<int, TaskInterface>> $tasks */
    private array $tasks = [];

    /**
     * @param TaskInterface[] $tasks
     */
    public function add(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->tasks[$task->getDay()][$task->getPart()] = $task;
        }
    }

    /**
     * @throws Exception
     */
    public function get(int $day, int $part): TaskInterface
    {
        if (!array_key_exists($day, $this->tasks)) {
            throw new Exception(sprintf('tasks for day %d are not in the list', $day));
        }
        $dayTasks = $this->tasks[$day];
        if (!array_key_exists($part, $dayTasks)) {
            throw new Exception(sprintf('task for day %d part %d is not in the list', $day, $part));
        }

        return $dayTasks[$part];
    }
}

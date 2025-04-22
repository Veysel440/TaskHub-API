<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(int $userId): array
    {
        return $this->taskRepository->allByUser($userId)->toArray();
    }

    public function createTask(array $data, int $userId): Task
    {
        $taskData = array_merge($data, ['user_id' => $userId]);
        $task = $this->taskRepository->create($taskData);

        if (!empty($data['tag_ids'])) {
            $this->taskRepository->attachTags($task, $data['tag_ids']);
        }

        return $task->load('tags');
    }

    public function getTask(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $this->taskRepository->update($task, $data);

        if (array_key_exists('tag_ids', $data)) {
            $this->taskRepository->syncTags($task, $data['tag_ids'] ?? []);
        }

        return $task->load('tags');
    }

    public function deleteTask(Task $task): bool
    {
        return $this->taskRepository->delete($task);
    }
}

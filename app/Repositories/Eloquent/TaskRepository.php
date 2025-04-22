<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function allByUser(int $userId): Collection
    {
        return Task::with('tags')->where('user_id', $userId)->get();
    }

    public function find(int $id): ?Task
    {
        return Task::with('tags')->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function attachTags(Task $task, array $tagIds): void
    {
        $task->tags()->attach($tagIds);
    }

    public function syncTags(Task $task, array $tagIds): void
    {
        $task->tags()->sync($tagIds);
    }
}

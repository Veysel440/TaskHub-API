<?php

namespace App\Repositories\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function allByUser(int $userId): Collection;
    public function find(int $id): ?Task;
    public function create(array $data): Task;
    public function update(Task $task, array $data): bool;
    public function delete(Task $task): bool;
    public function attachTags(Task $task, array $tagIds): void;
    public function syncTags(Task $task, array $tagIds): void;
}

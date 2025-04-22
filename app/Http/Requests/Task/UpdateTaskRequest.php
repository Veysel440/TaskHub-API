<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && $this->task->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'is_completed' => 'sometimes|boolean',
            'priority' => 'sometimes|in:low,medium,high',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ];
    }
}

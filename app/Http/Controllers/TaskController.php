<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="API Endpoints for managing tasks"
 * )
 */
class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="List all tasks for the authenticated user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of tasks",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Toplantı Notlarını Hazırla"),
     *                 @OA\Property(property="is_completed", type="boolean", example=false),
     *                 @OA\Property(property="priority", type="string", example="high"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Önemli"),
     *                         @OA\Property(property="slug", type="string", example="onemli"),
     *                         @OA\Property(property="type", type="string", example="priority")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks(auth()->id());
        return response()->json($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Create a new task",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Toplantı Notlarını Hazırla"),
     *             @OA\Property(property="priority", type="string", enum={"low", "medium", "high"}, example="high"),
     *             @OA\Property(
     *                 property="tag_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Toplantı Notlarını Hazırla"),
     *             @OA\Property(property="is_completed", type="boolean", example=false),
     *             @OA\Property(property="priority", type="string", example="high"),
     *             @OA\Property(
     *                 property="tags",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Önemli")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The title field is required.")
     *         )
     *     )
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated(), auth()->id());
        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Get a specific task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Toplantı Notlarını Hazırla")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function show(Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        $task = $this->taskService->getTask($task->id);
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Update a task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Toplantı Notlarını Güncelle"),
     *             @OA\Property(property="is_completed", type="boolean", example=true),
     *             @OA\Property(property="priority", type="string", enum={"low", "medium", "high"}, example="medium"),
     *             @OA\Property(
     *                 property="tag_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Toplantı Notlarını Güncelle")
     *         )
     *     )
     * )
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        $task = $this->taskService->updateTask($task, $request->validated());
        return response()->json($task);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Task deleted"
     *     )
     * )
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }

    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}

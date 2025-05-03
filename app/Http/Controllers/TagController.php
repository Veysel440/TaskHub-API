<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Tag(
 *     name="Tags",
 *     description="API Endpoints for managing tags"
 * )
 */
class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @OA\Get(
     *     path="/api/tags",
     *     tags={"Tags"},
     *     summary="List all tags",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of tags",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Önemli"),
     *                 @OA\Property(property="slug", type="string", example="onemli"),
     *                 @OA\Property(property="type", type="string", example="priority")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();
        return response()->json($tags);
    }

    /**
     * @OA\Post(
     *     path="/api/tags",
     *     tags={"Tags"},
     *     summary="Create a new tag",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Proje"),
     *             @OA\Property(property="type", type="string", example="category")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tag created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Proje")
     *         )
     *     )
     * )
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->createTag($request->validated());
        return response()->json($tag, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Get a specific tag",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Önemli")
     *         )
     *     )
     * )
     */
    public function show(Tag $tag): JsonResponse
    {
        $tag = $this->tagService->getTag($tag->id);
        return response()->json($tag);
    }

    /**
     * @OA\Put(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Update a tag",
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
     *             @OA\Property(property="name", type="string", example="Güncellenmiş Proje"),
     *             @OA\Property(property="type", type="string", example="category")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Güncellenmiş Proje")
     *         )
     *     )
     * )
     */
    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        $tag = $this->tagService->updateTag($tag, $request->validated());
        return response()->json($tag);
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Delete a tag",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tag deleted"
     *     )
     * )
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $this->tagService->deleteTag($tag);
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();
        return response()->json($tags);
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->createTag($request->validated());
        return response()->json($tag, 201);
    }

    public function show(Tag $tag): JsonResponse
    {
        $tag = $this->tagService->getTag($tag->id);
        return response()->json($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        $tag = $this->tagService->updateTag($tag, $request->validated());
        return response()->json($tag);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $this->tagService->deleteTag($tag);
        return response()->json(null, 204);
    }

    private function authorizeTag(Tag $tag): void
    {
        if ($tag->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}

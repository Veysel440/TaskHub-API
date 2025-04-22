<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Support\Str;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags(): array
    {
        return $this->tagRepository->all()->toArray();
    }

    public function createTag(array $data): Tag
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->tagRepository->create($data);
    }

    public function getTag(int $id): ?Tag
    {
        return $this->tagRepository->find($id);
    }

    public function updateTag(Tag $tag, array $data): Tag
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $this->tagRepository->update($tag, $data);
        return $tag;
    }

    public function deleteTag(Tag $tag): bool
    {
        return $this->tagRepository->delete($tag);
    }
}

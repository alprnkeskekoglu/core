<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\CategoryInterface;
use Dawnstar\Core\Models\Category;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class CategoryRepository implements CategoryInterface
{

    /**
     * @param int $id
     * @return Category
     */
    public function getById(int $id): Category
    {
        return Category::find($id);
    }

    /**
     * @param Structure $structure
     * @return Collection
     */
    public function getByStructure(Structure $structure): Collection
    {
        return Category::where('structure_id', $structure->id)->get();
    }

    /**
     * @param Structure $structure
     * @param int $status
     * @return Collection
     */
    public function getByStatus(Structure $structure, int $status): Collection
    {
        return Category::where('structure_id', $structure->id)->where('status', $status)->get();
    }

    /**
     * @param Structure $structure
     * @return Category
     */
    public function store(Structure $structure): Category
    {
        $data = request()->except(['_token', '_method', 'translations', 'languages', 'medias', 'meta_tags', 'relations', 'properties']);

        $data['structure_id'] = $structure->id;
        $data['container_id'] = $structure->container->id;

        $category = Category::create($data);
        $category->properties()->sync(request('properties', []));

        if (request('medias')) {
            $this->getMediaRepository()->syncMedias($category, request('medias'));
        }

        return $category;
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function update(Category $category): Category
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages', 'medias', 'meta_tags', 'relations', 'properties']);

        $category->update($requestData);
        $category->properties()->sync(request('properties', []));

        if (request('medias')) {
            $this->getMediaRepository()->syncMedias($category, request('medias'));
        }

        return $category;
    }

    /**
     * @param Category $category
     */
    public function destroy(Category $category): void
    {
        $category->delete();
    }

    /**
     * @return MediaRepository
     */
    private function getMediaRepository()
    {
        return new MediaRepository();
    }
}

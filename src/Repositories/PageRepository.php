<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\PageInterface;
use Dawnstar\Core\Models\Category;
use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class PageRepository implements PageInterface
{

    /**
     * @param int $id
     * @return Page
     */
    public function getById(int $id): Page
    {
        return Page::findOrFail($id);
    }

    /**
     * @param Structure $structure
     * @param int|null $status
     * @return Collection
     */
    public function getByStructure(Structure $structure, int $status = null): Collection
    {
        $pages = Page::where('structure_id', $structure->id);

        if ($status) {
            return $pages->where('status', $status)->get();
        }
        return $pages->get();
    }

    /**
     * @param Category $category
     * @param int|null $status
     * @return Collection
     */
    public function getByCategory(Category $category, int $status = null): Collection
    {
        $pages = $category->pages();

        if ($status) {
            return $pages->where('status', $status)->get();
        }
        return $pages->get();
    }

    /**
     * @param Structure $structure
     * @return Page
     */
    public function store(Structure $structure): Page
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages', 'medias', 'meta_tags', 'relations', 'categories', 'property_options']);

        $data = getTableColumns('pages', $requestData);
        $data['structure_id'] = $structure->id;
        $data['container_id'] = $structure->container->id;

        $page = Page::create($data);

        $this->getExtrasRepository()->store($page, $requestData);
        $this->syncSubPages($page);
        $this->syncCategories($page);
        $this->syncPropertyOptions($page);

        if (request('medias')) {
            $this->getMediaRepository()->syncMedias($page, request('medias'));
        }

        return $page;
    }

    /**
     * @param Page $page
     */
    public function update(Page $page): void
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages', 'medias', 'meta_tags', 'relations', 'categories', 'property_options']);

        $data = getTableColumns('pages', $requestData);

        $page->update($data);

        $this->getExtrasRepository()->store($page, $requestData);
        $this->syncSubPages($page);
        $this->syncCategories($page);
        $this->syncPropertyOptions($page);

        if (request('medias')) {
            $this->getMediaRepository()->syncMedias($page, request('medias'));
        }
    }

    /**
     * @param Page $page
     */
    public function destroy(Page $page): void
    {
        $page->delete();
    }

    /**
     * @param Page $page
     */
    public function syncSubPages(Page $page): void
    {
        $relations = request('relations');

        $page->subPages()->sync([]);
        if ($relations) {
            foreach ($relations as $key => $ids) {
                $page->subPages($key)->syncWithPivotValues($ids, ['key' => $key]);
            }
        }
    }

    /**
     * @param Page $page
     */
    public function syncCategories(Page $page)
    {
        $page->categories()->sync(request('categories', []));
    }

    /**
     * @param Page $page
     */
    public function syncPropertyOptions(Page $page)
    {
        $page->propertyOptions()->sync(request('property_options', []));
    }

    /**
     * @return ExtrasRepository
     */
    private function getExtrasRepository()
    {
        return new ExtrasRepository();
    }

    /**
     * @return MediaRepository
     */
    private function getMediaRepository()
    {
        return new MediaRepository();
    }
}

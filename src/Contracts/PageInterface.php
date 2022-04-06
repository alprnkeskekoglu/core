<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Category;
use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PageInterface
 * @package Dawnstar\Core\Contracts
 */
interface PageInterface extends BaseInterface
{
    /**
     * @param int $id
     * @return Page
     */
    public function getById(int $id): Page;

    /**
     * @param Structure $structure
     * @param int|null $status
     * @return Collection
     */
    public function getByStructure(Structure $structure, int $status = null): Collection;

    /**
     * @param Category $category
     * @param int|null $status
     * @return Collection
     */
    public function getByCategory(Category $category, int $status = null): Collection;

    /**
     * @param Structure $structure
     * @return Page
     */
    public function store(Structure $structure): Page;

    /**
     * @param Page $page
     */
    public function update(Page $page): void;

    /**
     * @param Page $page
     */
    public function destroy(Page $page): void;

    /**
     * @param Page $page
     */
    public function syncSubPages(Page $page): void;
}

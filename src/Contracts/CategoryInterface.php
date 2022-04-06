<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Category;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface CategoryInterface extends BaseInterface
{
    public function getById(int $id): Category;

    public function getByStructure(Structure $structure): Collection;

    public function getByStatus(Structure $structure, int $status): Collection;

    public function store(Structure $structure): Category;

    public function update(Category $category): Category;

    public function destroy(Category $category): void;
}

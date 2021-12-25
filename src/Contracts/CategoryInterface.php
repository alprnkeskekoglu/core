<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Category;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface CategoryInterface
{
    public function getById(int $id): Category;

    public function getByStructureId(Structure $structure): Collection;

    public function getByStatus(Structure $structure, int $status): Collection;

    public function store(Structure $structure): Category;

    public function update(Category $category);

    public function destroy(Category $category);
}

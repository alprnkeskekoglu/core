<?php

namespace Dawnstar\Contracts;

use Dawnstar\Models\Page;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface PageInterface
{
    public function getById(int $id): Page;

    public function getByStructureId(Structure $structure): Collection;

    public function getByStatus(Structure $structure, int $status): Collection;

    public function store(Structure $structure): Page;

    public function update(Page $page);

    public function destroy(Page $page);

    public function syncCustomPages(Page $page);
}
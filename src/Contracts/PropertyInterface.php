<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface PropertyInterface
{
    public function getById(int $id): Property;

    public function getByStructureId(Structure $structure): Collection;

    public function getByStatus(Structure $structure, int $status): Collection;

    public function store(Structure $structure): Property;

    public function update(Property $property);

    public function destroy(Property $property);
}

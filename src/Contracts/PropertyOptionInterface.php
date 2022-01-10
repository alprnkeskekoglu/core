<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\PropertyOption;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface PropertyOptionInterface
{
    public function getById(int $id): PropertyOption;

    public function getByProperty(Property $property): Collection;

    public function getByStatus(Property $property, int $status): Collection;

    public function store(Structure $structure, Property $property): PropertyOption;

    public function update(PropertyOption $propertyOption);

    public function destroy(PropertyOption $propertyOption);
}

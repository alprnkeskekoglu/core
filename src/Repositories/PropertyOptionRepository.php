<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\PropertyOptionInterface;
use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\PropertyOption;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class PropertyOptionRepository implements PropertyOptionInterface
{
    public function getById(int $id): PropertyOption
    {
        return PropertyOption::find($id);
    }

    public function getByProperty(Property $property): Collection
    {
        return PropertyOption::where('property_id', $property->id)->get();
    }

    public function getByStatus(Property $property, int $status): Collection
    {
        return PropertyOption::where('property_id', $property->id)->where('status', $status)->get();
    }

    public function store(Structure $structure, Property $property): PropertyOption
    {
        $data = request()->except(['_token', '_method', 'translations', 'languages']);

        $data['property_id'] = $property->id;

        return PropertyOption::create($data);
    }

    public function update(PropertyOption $propertyOption): void
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages']);

        $propertyOption->update($requestData);
    }

    public function destroy(PropertyOption $propertyOption): void
    {
        $propertyOption->delete();
    }
}

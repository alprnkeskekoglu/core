<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\PropertyInterface;
use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class PropertyRepository implements PropertyInterface
{

    public function getById(int $id): Property
    {
        return Property::find($id);
    }

    public function getByStructureId(Structure $structure): Collection
    {
        return Property::where('structure_id', $structure->id)->get();
    }

    public function getByStatus(Structure $structure, int $status): Collection
    {
        return Property::where('structure_id', $structure->id)->where('status', $status)->get();
    }

    public function store(Structure $structure): Property
    {
        $data = request()->except(['_token', '_method', 'translations', 'languages']);

        $data['structure_id'] = $structure->id;
        $data['container_id'] = $structure->container->id;

        $property = Property::create($data);

        return $property;
    }

    public function update(Property $property)
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages']);

        $property->update($requestData);

        return $property;
    }

    public function destroy(Property $property)
    {
        $property->delete();
    }
}

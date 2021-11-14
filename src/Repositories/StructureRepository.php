<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\StructureInterface;
use Dawnstar\Http\Requests\StructureRequest;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

class StructureRepository implements StructureInterface
{

    /**
     * @param int $id
     * @return Structure
     */
    public function getById(int $id): Structure
    {
        return Structure::findOrFail($id);
    }

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection
    {
        return Structure::where('website_id', session('dawnstar.website.id'))->where('status', $status)->get();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Structure::where('website_id', session('dawnstar.website.id'))->get();
    }

    /**
     * @param StructureRequest $structureRequest
     * @return Structure
     */
    public function store(StructureRequest $structureRequest): Structure
    {
        $data = $structureRequest->only(['status', 'type', 'key', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);

        $data['website_id'] = session('dawnstar.website.id');

        return Structure::create($data);
    }

    /**
     * @param Structure $structure
     * @param StructureRequest $structureRequest
     * @return mixed|void
     */
    public function update(Structure $structure, StructureRequest $structureRequest)
    {
        $data = $structureRequest->only(['status', 'type', 'key', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);

        $structure->update($data);
    }

    /**
     * @param Structure $structure
     * @return mixed|void
     */
    public function destroy(Structure $structure)
    {
        $structure->delete();
    }
}

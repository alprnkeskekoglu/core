<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Http\Requests\StructureRequest;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\Interfaces\StructureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StructureRepository implements StructureRepositoryInterface
{
    public function __construct(protected Structure $model)
    {
    }

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
        return Structure::where('website_id', session('dawnstar.website.id'))->with('container.translation')->get();
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

    /**
     * @param Website $website
     * @return Structure|null
     */
    public function getHomePageByWebsite(Website $website): ?Structure
    {
        return $this->model->where('website_id', $website->id)->where('key', 'homepage')->first();
    }
}

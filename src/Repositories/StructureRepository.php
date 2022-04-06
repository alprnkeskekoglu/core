<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\StructureInterface;
use Dawnstar\Core\Http\Requests\StructureRequest;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Services\ModuleFileService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class StructureRepository
 * @package Dawnstar\Core\Repositories
 */
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
        return Structure::where('website_id', session('dawnstar.website.id'))->with('container.translation')->get();
    }

    /**
     * @return bool
     */
    public function hasHomepage(): bool
    {
        return Structure::where('key', 'homepage')->exists();
    }

    /**
     * @return bool
     */
    public function hasSearch(): bool
    {
        return Structure::where('key', 'search')->exists();
    }

    /**
     * @return Structure
     */
    public function store(): Structure
    {
        $data = request()->only(['status', 'type', 'key', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);
        $data['website_id'] = session('dawnstar.website.id');

        $structure = Structure::create($data);

        $moduleBuilderRepository = new ModuleBuilderRepository();
        $moduleBuilderRepository->store($structure);

        if(config('app.env') == 'local') {
            $this->createFiles($structure);
        }

        return $structure;
    }

    /**
     * @param Structure $structure
     */
    public function update(Structure $structure): void
    {
        $data = request()->only(['status', 'type', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);

        $structure->update($data);
    }

    /**
     * @param Structure $structure
     */
    public function destroy(Structure $structure): void
    {
        $structure->delete();
    }


    private function createFiles(Structure $structure): void
    {
        $service = new ModuleFileService($structure);
        $service->createController();
        $service->createBlades();
    }
}

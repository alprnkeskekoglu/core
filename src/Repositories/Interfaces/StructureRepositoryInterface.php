<?php

namespace Dawnstar\Core\Repositories\Interfaces;

use Dawnstar\Core\Http\Requests\StructureRequest;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Website;
use Illuminate\Database\Eloquent\Collection;

interface StructureRepositoryInterface
{
    /**
     * @param int $id
     * @return Structure
     */
    public function getById(int $id): Structure;

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param StructureRequest $structureRequest
     * @return Structure
     */
    public function store(StructureRequest $structureRequest): Structure;

    /**
     * @param Structure $structure
     * @param StructureRequest $structureRequest
     * @return mixed
     */
    public function update(Structure $structure, StructureRequest $structureRequest);

    /**
     * @param Structure $structure
     * @return mixed
     */
    public function destroy(Structure $structure);

    /**
     * @param Website $website
     * @return Structure|null
     */
    public function getHomePageByWebsite(Website $website): ?Structure;
}
<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Http\Requests\StructureRequest;
use Dawnstar\Core\Models\Structure;

interface StructureInterface extends BaseInterface
{
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
}

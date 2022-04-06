<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface StructureInterface
 * @package Dawnstar\Core\Contracts
 */
interface StructureInterface
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
     * @return bool
     */
    public function hasHomepage(): bool;

    /**
     * @return bool
     */
    public function hasSearch(): bool;

    /**
     * @return Structure
     */
    public function store(): Structure;

    /**
     * @param Structure $structure
     */
    public function update(Structure $structure): void;

    /**
     * @param Structure $structure
     */
    public function destroy(Structure $structure): void;
}

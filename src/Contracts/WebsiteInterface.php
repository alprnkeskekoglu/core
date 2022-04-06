<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Website;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface WebsiteInterface
 * @package Dawnstar\Core\Contracts
 */
interface WebsiteInterface extends BaseInterface
{
    /**
     * @param int $id
     * @return Website
     */
    public function getById(int $id): Website;

    /**
     * @return Website
     */
    public function getDefault(): Website;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection;

    /**
     * @return Website
     */
    public function store(): Website;

    /**
     * @param Website $website
     * @return Website
     */
    public function update(Website $website): Website;

    /**
     * @param Website $website
     */
    public function destroy(Website $website): void;

    /**
     * @param Website $website
     */
    public function setSession(Website $website): void;
}

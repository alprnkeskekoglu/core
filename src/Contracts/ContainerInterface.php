<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ContainerInterface
 * @package Dawnstar\Core\Contracts
 */
interface ContainerInterface extends BaseInterface
{
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
     * @param Structure $structure
     * @return Container
     */
    public function store(Structure $structure): Container;

    /**
     * @param Container $container
     */
    public function update(Container $container): void;

    /**
     * @param Container $container
     */
    public function syncSubPages(Container $container): void;
}

<?php

namespace Dawnstar\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BaseInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection;
}

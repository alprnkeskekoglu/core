<?php

namespace Dawnstar\Core\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);
}

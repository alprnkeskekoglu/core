<?php

namespace Dawnstar\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ExtrasInterface
{
    public function store($model, array $data);
}

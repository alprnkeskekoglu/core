<?php

namespace Dawnstar\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

interface TranslationInterface
{
    public function store($model);

    public function update($model);
}

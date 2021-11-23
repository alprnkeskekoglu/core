<?php

namespace Dawnstar\Contracts;

use Illuminate\Database\Eloquent\Model;

interface TranslationInterface
{
    public function store($model);

    public function update($model);
}

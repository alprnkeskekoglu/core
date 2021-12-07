<?php

namespace Dawnstar\Contracts;

use Illuminate\Database\Eloquent\Model;

interface MetaTagInterface
{
    public function sync($model, $data);
}

<?php

namespace Dawnstar\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

interface MetaTagInterface
{
    public function sync($model, $data);
}

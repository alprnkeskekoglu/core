<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\ExtrasInterface;
use Illuminate\Support\Facades\Schema;

class ExtrasRepository implements ExtrasInterface
{
    public function store($model, array $data)
    {
        $model->extras()->forceDelete();

        foreach ($data as $key => $value) {
            if(!Schema::hasColumn($model->getTable(), $key)) {
                dd($model->getTable(), $key);
                if(is_array($value)) {
                    foreach ($value as $v) {
                        $model->extras()->create([
                            'key' => $key,
                            'value' => $v
                        ]);
                    }
                } else {
                    $model->extras()->create([
                        'key' => $key,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}

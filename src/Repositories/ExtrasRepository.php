<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\ExtrasInterface;
use Dawnstar\Models\PageExtra;
use Illuminate\Support\Facades\Schema;

class ExtrasRepository implements ExtrasInterface
{
    public function store($page, $data)
    {
        $page->extras()->forceDelete();

        foreach ($data as $key => $value) {
            if(!Schema::hasColumn($page->getTable(), $key)) {
                if(is_array($value)) {
                    foreach ($value as $v) {
                        $page->extras()->create([
                            'page_id' => $page->id,
                            'key' => $key,
                            'value' => $v
                        ]);
                    }
                } else {
                    $page->extras()->create([
                        'page_id' => $page->id,
                        'key' => $key,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}

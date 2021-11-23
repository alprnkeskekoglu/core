<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\PageInterface;
use Dawnstar\Models\Page;
use Dawnstar\Models\PageExtra;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class PageRepository implements PageInterface
{

    public function getById(int $id): Page
    {
        return Page::find($id);
    }

    public function getByStructureId(Structure $structure): Collection
    {
        return Page::where('structure_id', $structure->id)->get();
    }

    public function getByStatus(Structure $structure, int $status): Collection
    {
        return Page::where('structure_id', $structure->id)->where('status', $status)->get();
    }

    public function store(Structure $structure): Page
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages']);

        $extras = $data = [];

        foreach ($requestData as $key => $value) {
            if(!Schema::hasColumn('pages', $key)) {
                if(is_array($value)) {
                    foreach ($value as $v) {
                        $extras[] = new PageExtra(['key' => $key, 'value' => $v]);
                    }
                } else {
                    $extras[] = new PageExtra(['key' => $key, 'value' => $value]);
                }
            } else {
                $data[$key] = $value;
            }
        }

        $data['structure_id'] = $structure->id;
        $data['container_id'] = $structure->container->id;
        $page = Page::create($data);
        $page->extras()->saveMany($extras);

        return $page;
    }

    public function update(Structure $structure, Page $page)
    {
        // TODO: Implement update() method.
    }

    public function destroy(Structure $structure, Page $page)
    {
        // TODO: Implement destroy() method.
    }

    public function datatable()
    {

    }
}

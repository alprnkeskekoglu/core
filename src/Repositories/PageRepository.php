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

        $data = [];

        foreach ($requestData as $key => $value) {
            if(Schema::hasColumn('pages', $key)) {
                $data[$key] = $value;
            }
        }
        $data['structure_id'] = $structure->id;
        $data['container_id'] = $structure->container->id;
        $page = Page::create($data);
        $this->getExtrasRepository()->store($page, $requestData);

        return $page;
    }

    public function update(Page $page)
    {
        $requestData = request()->except(['_token', '_method', 'translations', 'languages']);

        $page->update($requestData);

        $this->getExtrasRepository()->store($page, $requestData);

        return $page;
    }

    public function destroy(Page $page)
    {
        $page->delete();
    }

    private function getExtrasRepository()
    {
        return new ExtrasRepository();
    }
}

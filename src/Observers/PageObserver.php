<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\Page;
use Illuminate\Support\Facades\DB;

class PageObserver
{
    public function created(Page $page)
    {
        $this->updateOrder($page);
    }

    public function updated(Page $page)
    {
        $this->updateOrder($page);
    }

    private function updateOrder(Page $page)
    {
        Page::where('structure_id', $page->structure_id)
            ->where('order', '>=', $page->order)
            ->where('id', '!=', $page->id)
            ->where('status', 1)
            ->increment('order', 1);

        DB::statement(DB::raw("SET @r=0"));
        DB::statement(DB::raw("UPDATE `pages` SET `order`=@r:=(@r+1) WHERE `status`=1 AND `structure_id`='{$page->structure_id}' AND `deleted_at` IS NULL ORDER BY `order` ASC ,`updated_at`"));
    }
}

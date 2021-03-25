<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Menu as StructureModel;
use Dawnstar\Models\MenuContent;

class Menu
{
    public $language;
    public $website;
    public string $key;

    /**
     * Menu constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $dawnstar = dawnstar();
        $this->language = $dawnstar->language;
        $this->website = $dawnstar->website;
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function init(): array
    {
        $menuStructure = $this->getMenuStructure();
        $currentMenu = $this->getCurrentMenu($menuStructure);
        $activeMenuIds = $this->getActiveMenuIds($currentMenu);
        $menus = $this->getMenus($menuStructure);

        return $this->getMenuArray($menus, $activeMenuIds);
    }

    /**
     * @param $menus
     * @param array $activeMenuIds
     * @return array
     */
    private function getMenuArray($menus, array $activeMenuIds): array
    {
        $hold = [];

        foreach ($menus as $menu) {

            if ($menu->type == 1) {
                $menuLink = url($menu->url->url);
            } elseif ($menu->type == 2) {
                $menuLink = $menu->out_link;
            } else {
                $menuLink = 'javascript:void(0)';
            }

            $temp = [
                'id' => $menu->id,
                'name' => $menu->name,
                'url' => $menuLink,
                'target' => $menu->target,
                'active' => in_array($menu->id, $activeMenuIds),
            ];

            if ($menu->children->isNotEmpty()) {
                $children = $menu->children()->orderBy('lft')->get();
                $temp['children'] = $this->getMenuArray($children, $activeMenuIds);
            } else {
                $temp['children'] = [];
            }

            $hold[] = $temp;
        }
        return $hold;
    }

    /**
     * @param StructureModel $menuStructure
     * @return mixed
     */
    private function getCurrentMenu(StructureModel $menuStructure)
    {
        $url = request()->path();

        return MenuContent::where('status', 1)
            ->where('menu_id', $menuStructure->id)
            ->whereHas('url', function ($q) use ($url) {
                $q->where("url", "LIKE", "%$url%");
            })
            ->first();
    }

    /**
     * @param MenuContent $currentMenu
     * @return array
     */
    private function getActiveMenuIds(MenuContent $currentMenu): array
    {
        $parentIds = MenuContent::where('menu_id', $currentMenu->menu_id)
            ->where("lft", "<=", $currentMenu->lft)
            ->where("rgt", ">=", $currentMenu->rgt)
            ->where("language_id", $this->language->id)
            ->orderBy('lft')
            ->pluck('id')
            ->toArray();

        $parentIds[] = $currentMenu->id;

        return $parentIds;
    }

    /**
     * @param StructureModel $menuStructure
     * @return mixed
     */
    private function getMenus(StructureModel $menuStructure)
    {
        return $menuStructure->contents()
            ->where('language_id', $this->language->id)
            ->where('status', 1)
            ->where('parent_id', 0)
            ->orderBy('lft')
            ->get();
    }

    /**
     * @return StructureModel
     */
    private function getMenuStructure(): StructureModel
    {
        return StructureModel::where('key', $this->key)
            ->where('website_id', $this->website->id)
            ->where('status', 1)
            ->first();
    }
}

<?php

namespace Dawnstar\Core\Services;

use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\MenuItem;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    /**
     * @var Language|mixed
     */
    public Language $language;
    /**
     * @var Website|mixed
     */
    public Website $website;

    /**
     * Menu constructor.
     * @param string $key
     */
    public function __construct(public string $key)
    {
        $this->language = dawnstar()->language;
        $this->website = dawnstar()->website;
    }

    /**
     * @return array
     */
    public function init(): array
    {
        $menu = $this->getMenu();

        if(is_null($menu)) {
            return [];
        }

        $currentMenuItem = $this->getCurrentMenuItem($menu);
        $menuItemIds = $currentMenuItem ? $this->getActiveMenuItemIds($currentMenuItem) : [];
        $menus = $this->getMenus($menu);

        return $this->getMenuItemArray($menus, $menuItemIds);
    }

    /**
     * @return Menu|null
     */
    private function getMenu(): ?Menu
    {
        return Menu::where('key', $this->key)
            ->where('website_id', $this->website->id)
            ->active()
            ->first();
    }

    /**
     * @param Menu $menu
     * @return mixed
     */
    private function getCurrentMenuItem(Menu $menu)
    {
        $url = request()->path();

        return $menu->items()
            ->whereHas('url', function ($q) use ($url) {
                $q->where("url", "like", "%$url%");
            })
            ->first();
    }

    /**
     * @param MenuItem $currentMenuItem
     * @return array
     */
    private function getActiveMenuItemIds(MenuItem $currentMenuItem): array
    {
        $parentIds = MenuItem::where('menu_id', $currentMenuItem->menu_id)
            ->where("left", "<=", $currentMenuItem->left)
            ->where("right", ">=", $currentMenuItem->right)
            ->where("language_id", $this->language->id)
            ->active()
            ->orderBy('left')
            ->pluck('id')
            ->toArray();

        $parentIds[] = $currentMenuItem->id;

        return $parentIds;
    }

    /**
     * @param Menu $menu
     * @return mixed
     */
    private function getMenus(Menu $menu)
    {
        return $menu->items()
            ->where('language_id', $this->language->id)
            ->active()
            ->where('parent_id', 0)
            ->orderBy('left')
            ->get();
    }

    /**
     * @param Collection $menus
     * @param array $activeMenuIds
     * @return array
     */
    private function getMenuItemArray(Collection $menus, array $activeMenuIds = []): array
    {
        $hold = [];

        foreach ($menus as $menu) {

            if ($menu->type == 1) {
                $menuLink = url($menu->url->url);
            } elseif ($menu->type == 2) {
                $menuLink = $menu->external_link;
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
                $children = $menu->children()->orderBy('left')->get();
                $temp['children'] = $this->getMenuItemArray($children, $activeMenuIds);
            } else {
                $temp['children'] = [];
            }

            $hold[] = $temp;
        }
        return $hold;
    }
}

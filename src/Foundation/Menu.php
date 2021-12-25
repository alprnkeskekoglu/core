<?php

namespace Dawnstar\Core\Foundation;

use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\MenuItem;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Menu as Model;
use Illuminate\Database\Eloquent\Collection;

class Menu
{
    public Language $language;
    public Website $website;
    public string $key;

    /**
     * Menu constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->language = dawnstar()->language;
        $this->website = dawnstar()->website;
        $this->key = $key;
    }

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

    private function getMenu(): ?Model
    {
        return Model::where('key', $this->key)
            ->where('website_id', $this->website->id)
            ->active()
            ->first();
    }

    private function getCurrentMenuItem(Model $menu)
    {
        $url = request()->path();

        return MenuItem::active()
            ->where('menu_id', $menu->id)
            ->whereHas('url', function ($q) use ($url) {
                $q->where("url", "LIKE", "%$url%");
            })
            ->first();
    }

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

    private function getMenus(Model $menu)
    {
        return $menu->items()
            ->where('language_id', $this->language->id)
            ->active()
            ->where('parent_id', 0)
            ->orderBy('left')
            ->get();
    }

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

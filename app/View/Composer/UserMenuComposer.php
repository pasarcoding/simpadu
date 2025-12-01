<?php

namespace App\View\Composer;

use Illuminate\View\View;
use Modules\Appearance\App\Models\AppearanceMenu;
use Modules\Information\App\Models\Information;
use Modules\News\App\Models\News;

class UserMenuComposer
{
    public function compose(View $view)
    {
        // $defaultMenuUser = collect(getDefaultUserMenuList());
        // $appearanceMenus = AppearanceMenu::with('appearance_page')->get();
        // $groupedByType = collect($appearanceMenus)->groupBy('type');

        // $headerMenu = $this->buildTree($groupedByType->get('header', collect()), $defaultMenuUser, null);
        // $footerMenu = $this->buildTree($groupedByType->get('footer', collect()), $defaultMenuUser, null);

        // $view->with('headerMenu', $headerMenu)
        //     ->with('footerMenu', $footerMenu);

        $defaultMenuUser = collect(getDefaultUserMenuList());

        $appearanceMenus = AppearanceMenu::with('appearance_page')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $groupedByType = $appearanceMenus->groupBy('type');

        $headerMenusRaw = $groupedByType->get('header', collect())->sortBy('order');
        $footerMenusRaw = $groupedByType->get('footer', collect())->sortBy('order');

        $headerMenu = $this->buildTree($headerMenusRaw, $defaultMenuUser, null);
        $footerMenu = $this->buildTree($footerMenusRaw, $defaultMenuUser, null);

        $view->with('headerMenu', $headerMenu)
            ->with('footerMenu', $footerMenu);
    }

    protected function buildTree($elements, $defaultMenuUser, $parent_id = null)
    {
        $branch = [];

        $filteredElements = $elements->filter(function ($element) use ($parent_id) {
            return $element->parent_id == $parent_id;
        });

        foreach ($filteredElements as $element) {
            $children = $this->buildTree($elements, $defaultMenuUser, $element->id);

            if ($children) {
                $element->children = collect($children)->sortBy('order')->values()->all();
            } else {
                $element->children = [];
            }

            if ($element->page_origin == 'in') {
                if ($element->appearance_page_id != null && $element->appearance_page) {
                    $element->url = route('user.appearance.page.index', $element->appearance_page->slug);
                } elseif ($element->default_page_id != null) {
                    $defaultPage = $defaultMenuUser->where('id', $element->default_page_id)->first();
                    $element->url = $defaultPage ? $defaultPage->route : null;
                } else {
                    $element->url = null;
                }
            } else {
                $element->url = $element->url;
            }

            $branch[] = $element;
        }

        return $branch;
    }
}

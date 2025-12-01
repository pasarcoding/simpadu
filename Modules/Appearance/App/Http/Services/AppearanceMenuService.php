<?php

namespace Modules\Appearance\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\App\Models\AppearanceMenu;
use Yajra\DataTables\Facades\DataTables;

class AppearanceMenuService
{
    public function get()
    {
        $query = AppearanceMenu::select(['id', 'parent_id', 'name', 'url', 'type', 'behaviour_target', 'page_origin', 'appearance_page_id', 'default_page_id', 'order'])
            ->with(['parent', 'children', 'appearance_page'])
            ->orderBy('created_at', 'desc');

        $defaultMenuUser = collect(getDefaultUserMenuList());

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('parent_name', function ($row) {
                if ($row->parent_id == null || $row->parent_id == '') {
                    return 'Menu Utama';
                }

                return $row->parent->name;
            })
            ->addColumn('parse_url', function ($row) use ($defaultMenuUser) {
                if ($row->page_origin == 'in') {
                    if ($row->appearance_page_id != null) {
                        $text = route('user.appearance.page.index', $row->appearance_page->slug);
                    } else {
                        $text = $defaultMenuUser->where('id', $row->default_page_id)->first()->route;
                    }
                } else {
                    $text = $row->url;
                }
                return truncateText($text);
            })
            ->editColumn('type', function ($row) {
                return getAppearanceMenuTypeList()[$row->type];
            })
            ->editColumn('behaviour_target', function ($row) {
                return getAppearanceMenuBehaviourTargetList()[$row->behaviour_target];
            })
            ->addColumn('action', function ($row) use ($defaultMenuUser) {
                if ($row->page_origin == 'in') {
                    if ($row->appearance_page_id != null) {
                        $url = route('user.appearance.page.index', $row->appearance_page->slug);
                    } else {
                        $url = $defaultMenuUser->where('id', $row->default_page_id)->first()->route;
                    }
                } else {
                    $url = $row->url;
                }

                $btn = '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';

                if (auth()->user()->can(PermissionName::appearance_menu_edit())) {
                    $btn .= ' <a href="' . route('admin.appearance.menu.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::appearance_menu_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.appearance.menu.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['url', 'action'])
            ->make(true);
    }

    public function store($data)
    {

        DB::beginTransaction();
        try {
            if ($data['page_origin'] == 'in' && str_starts_with($data['appearance_page_id'], 'um-')) {
                $data['default_page_id'] = $data['appearance_page_id'];
                $data['appearance_page_id'] = null;
            }

            $appearanceMenu = AppearanceMenu::create($data);

            DB::commit();
            return $appearanceMenu;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getDescendantIds(int $parentId): array
    {
        $excludedIds = [$parentId];
        $children = AppearanceMenu::select(['id'])->where('parent_id', $parentId)->get();

        foreach ($children as $child) {
            $excludedIds = array_merge($excludedIds, $this->getDescendantIds($child->id));
        }

        return array_unique($excludedIds);
    }

    public function update(AppearanceMenu $appearanceMenu, $data)
    {
        DB::beginTransaction();
        try {
            if ($data['page_origin'] == 'in' && str_starts_with($data['appearance_page_id'], 'um-')) {
                $data['default_page_id'] = $data['appearance_page_id'];
                $data['appearance_page_id'] = null;
            }

            $appearanceMenu->update($data);

            DB::commit();
            return $appearanceMenu;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(AppearanceMenu $appearanceMenu)
    {
        DB::beginTransaction();
        try {
            $delete = $appearanceMenu->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

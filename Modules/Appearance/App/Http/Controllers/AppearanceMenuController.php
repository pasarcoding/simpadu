<?php

namespace Modules\Appearance\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Appearance\App\Http\Requests\AppearanceMenuRequest;
use Modules\Appearance\App\Http\Services\AppearanceMenuService;
use Modules\Appearance\App\Models\AppearanceMenu;
use Modules\Appearance\App\Models\AppearancePage;

class AppearanceMenuController extends Controller
{
    protected $appearanceMenuService;

    public function __construct(AppearanceMenuService $appearanceMenuService)
    {
        $this->appearanceMenuService = $appearanceMenuService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->appearanceMenuService->get();
        }

        return view('appearance::admin.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = AppearanceMenu::select(['id', 'name'])->get();
        $menus->prepend((object)[
            'id' => null,
            'name' => 'Menu Utama'
        ]);
        $pages = AppearancePage::select(['id', 'title'])->get();
        foreach (collect(getDefaultUserMenuList())->reverse() as $item) {
            $pages->prepend($item);
        }

        return view('appearance::admin.menu.create', [
            'menus' => $menus,
            'pages' => $pages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppearanceMenuRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->appearanceMenuService->store($data);

            return redirect()
                ->route('admin.appearance.menu.index')
                ->with('success', 'Data Menu berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Menu:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(AppearanceMenu $appearanceMenu) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppearanceMenu $appearanceMenu)
    {
        $descendantIds = $this->appearanceMenuService->getDescendantIds($appearanceMenu->id);

        $menus = AppearanceMenu::select(['id', 'name'])->whereNotIn('id', $descendantIds)->get();
        $menus->prepend((object)[
            'id' => null,
            'name' => 'Menu Utama'
        ]);
        $pages = AppearancePage::select(['id', 'title'])->get();
        foreach (collect(getDefaultUserMenuList())->reverse() as $item) {
            $pages->prepend($item);
        }

        return view('appearance::admin.menu.edit', [
            'data' => $appearanceMenu,
            'menus' => $menus,
            'pages' => $pages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppearanceMenuRequest $request, AppearanceMenu $appearanceMenu): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->appearanceMenuService->update($appearanceMenu, $data);

            return redirect()
                ->route('admin.appearance.menu.index')
                ->with('success', 'Data Menu berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Menu:", ['error' => $e->getMessage(), 'id' => $appearanceMenu->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppearanceMenu $appearanceMenu): RedirectResponse
    {
        try {
            $this->appearanceMenuService->destroy($appearanceMenu);

            return redirect()
                ->route('admin.appearance.menu.index')
                ->with('success', 'Data Menu berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Menu:", ['error' => $e->getMessage(), 'id' => $appearanceMenu->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

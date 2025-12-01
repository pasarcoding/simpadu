<?php

namespace Modules\Budget\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Budget\App\Http\Requests\ItemBudgetRequest;
use Modules\Budget\App\Http\Services\ItemBudgetService;
use Modules\Budget\App\Models\Budget;
use Modules\Budget\App\Models\ItemBudget;

class ItemBudgetController extends Controller
{
    protected $itemBudgetService;

    public function __construct(ItemBudgetService $itemBudgetService)
    {
        $this->itemBudgetService = $itemBudgetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget, Request $request)
    {
        if ($request->ajax()) {
            return $this->itemBudgetService->get($budget);
        }

        return view('budget::admin.item_budget.index', [
            'data' => $budget,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Budget $budget)
    {
        return view('budget::admin.item_budget.create', [
            'data' => $budget,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Budget $budget, ItemBudgetRequest $request): RedirectResponse
    {
        $data = $request->validated('item_budgets');

        try {
            $this->itemBudgetService->store($budget, $data);

            return redirect()
                ->route('admin.budget.detail.index', $budget->id)
                ->with('success', 'Data Detail Anggaran berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Detail Anggaran:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(ItemBudget $itemBudget) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemBudget $itemBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemBudgetRequest $request, ItemBudget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget, ItemBudget $itemBudget): RedirectResponse
    {
        try {
            $this->itemBudgetService->destroy($itemBudget);

            return redirect()
                ->route('admin.budget.detail.index', $budget->id)
                ->with('success', 'Data Detail Anggaran berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Detail Anggaran:", ['error' => $e->getMessage(), 'id' => $budget->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

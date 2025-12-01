<?php

namespace Modules\Budget\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Budget\App\Http\Requests\BudgetRequest;
use Modules\Budget\App\Http\Services\BudgetService;
use Modules\Budget\App\Models\Budget;

class BudgetController extends Controller
{
    protected $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->budgetService->get();
        }

        return view('budget::admin.budget.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('budget::admin.budget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->budgetService->store($data);

            return redirect()
                ->route('admin.budget.index')
                ->with('success', 'Data Anggaran berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Anggaran:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Budget $budget) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        return view('budget::admin.budget.edit', [
            'data' => $budget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetRequest $request, Budget $budget): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->budgetService->update($budget, $data);

            return redirect()
                ->route('admin.budget.index')
                ->with('success', 'Data Anggaran berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Anggaran:", ['error' => $e->getMessage(), 'id' => $budget->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget): RedirectResponse
    {
        try {
            $this->budgetService->destroy($budget);

            return redirect()
                ->route('admin.budget.index')
                ->with('success', 'Data Berita berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Berita:", ['error' => $e->getMessage(), 'id' => $budget->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

<?php

namespace Modules\CritiqueSuggestion\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\CritiqueSuggestion\App\Http\Requests\CritiqueSuggestionRequest;
use Modules\CritiqueSuggestion\App\Http\Services\CritiqueSuggestionService;
use Modules\CritiqueSuggestion\App\Models\CritiqueSuggestion;

class CritiqueSuggestionController extends Controller
{
    protected $critiqueSuggestionService;

    public function __construct(CritiqueSuggestionService $critiqueSuggestionService)
    {
        $this->critiqueSuggestionService = $critiqueSuggestionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->critiqueSuggestionService->get();
        }

        return view('critiquesuggestion::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CritiqueSuggestionRequest $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(CritiqueSuggestion $critiqueSuggestion) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CritiqueSuggestion $critiqueSuggestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CritiqueSuggestionRequest $request, CritiqueSuggestion $critiqueSuggestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CritiqueSuggestion $critiqueSuggestion): RedirectResponse
    {
        try {
            $this->critiqueSuggestionService->destroy($critiqueSuggestion);

            return redirect()
                ->route('admin.critique-suggestion.index')
                ->with('success', 'Data Kritik & Saran berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Kritik & Saran:", ['error' => $e->getMessage(), 'id' => $critiqueSuggestion->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

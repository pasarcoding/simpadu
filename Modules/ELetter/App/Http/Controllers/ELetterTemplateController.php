<?php

namespace Modules\ELetter\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\ELetter\App\Http\Requests\ELetterTemplateRequest;
use Modules\ELetter\App\Http\Services\ELetterTemplateService;
use Modules\ELetter\App\Models\ELetterTemplate;

class ELetterTemplateController extends Controller
{
    protected $eLetterTemplateService;

    public function __construct(ELetterTemplateService $eLetterTemplateService)
    {
        $this->eLetterTemplateService = $eLetterTemplateService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->eLetterTemplateService->get();
        }

        return view('eletter::admin.template.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eletter::admin.template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ELetterTemplateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->eLetterTemplateService->store($data);

            return redirect()
                ->route('admin.e-letter.template.index')
                ->with('success', 'Data Template Surat berhasil ditambahkan.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Gagal Store Template Surat:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(ELetterTemplate $eLetterTemplate) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ELetterTemplate $eLetterTemplate)
    {
        return view('eletter::admin.template.edit', [
            'data' => $eLetterTemplate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ELetterTemplateRequest $request, ELetterTemplate $eLetterTemplate): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->eLetterTemplateService->update($eLetterTemplate, $data);

            return redirect()
                ->route('admin.e-letter.template.index')
                ->with('success', 'Data Template Surat berhasil diperbarui.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Gagal Update Template Surat:", ['error' => $e->getMessage(), 'id' => $eLetterTemplate->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ELetterTemplate $eLetterTemplate): RedirectResponse
    {
        try {
            $this->eLetterTemplateService->destroy($eLetterTemplate);

            return redirect()
                ->route('admin.e-letter.template.index')
                ->with('success', 'Data Template Surat berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Template Surat:", ['error' => $e->getMessage(), 'id' => $eLetterTemplate->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

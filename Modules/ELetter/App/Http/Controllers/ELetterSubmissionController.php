<?php

namespace Modules\ELetter\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\ELetter\App\Http\Requests\ELetterSubmissionRequest;
use Modules\ELetter\App\Http\Services\ELetterSubmissionService;
use Modules\ELetter\App\Models\ELetterSubmission;

class ELetterSubmissionController extends Controller
{
    protected $eLetterSubmissionService;

    public function __construct(ELetterSubmissionService $eLetterSubmissionService)
    {
        $this->eLetterSubmissionService = $eLetterSubmissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->eLetterSubmissionService->get();
        }

        return view('eletter::admin.submission.index');
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
    public function store(ELetterSubmissionRequest $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(ELetterSubmission $eLetterSubmission)
    {
        $eLetterSubmission->load(['e_letter_template', 'resident']);

        return view('eletter::admin.submission.detail', [
            'data' => $eLetterSubmission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ELetterSubmission $eLetterSubmission)
    {
        $eLetterSubmission->load('e_letter_template');

        return view('eletter::admin.submission.edit', [
            'data' => $eLetterSubmission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ELetterSubmissionRequest $request, ELetterSubmission $eLetterSubmission): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->eLetterSubmissionService->update($eLetterSubmission, $data);

            return redirect()
                ->route('admin.e-letter.submission.index')
                ->with('success', 'Data Pengajuan Surat berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Pengajuan Surat:", ['error' => $e->getMessage(), 'id' => $eLetterSubmission->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ELetterSubmission $eLetterSubmission): RedirectResponse
    {
        try {
            $this->eLetterSubmissionService->destroy($eLetterSubmission);

            return redirect()
                ->route('admin.e-letter.submission.index')
                ->with('success', 'Data Pengajuan Surat berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Pengajuan Surat:", ['error' => $e->getMessage(), 'id' => $eLetterSubmission->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }

    public function download(ELetterSubmission $eLetterSubmission)
    {
        $eLetterSubmission->load(['e_letter_template']);

        try {
            $filePath = $this->eLetterSubmissionService->download($eLetterSubmission);

            return response()->download($filePath, null, [], 'inline')->deleteFileAfterSend(true);
        } catch (Exception $e) {
            Log::error("Gagal Download Pengajuan Surat:", ['error' => $e->getMessage(), 'id' => $eLetterSubmission->id]);
            return 'gagal';
        }
    }
}

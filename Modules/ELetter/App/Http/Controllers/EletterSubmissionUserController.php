<?php

namespace Modules\ELetter\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\ELetter\App\Http\Requests\ELetterSubmissionUserRequest;
use Modules\ELetter\App\Http\Services\ELetterSubmissionUserService;
use Modules\ELetter\App\Models\ELetterTemplate;
use Modules\Resident\App\Models\Resident;

class EletterSubmissionUserController extends Controller
{
    protected $eLetterSubmissionUserService;

    public function __construct(ELetterSubmissionUserService $eLetterSubmissionUserService)
    {
        $this->eLetterSubmissionUserService = $eLetterSubmissionUserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eLetters = ELetterTemplate::select('id', 'name', 'list_variables')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('eletter::user.index', [
            'eLetters' => $eLetters,
        ]);
    }

    public function residentByNationalID(Request $request)
    {
        // $request->validate([
        //     'national_id' => ['required', Rule::exists(Resident::class, 'national_id')],
        //     'e_letter_template_id' => ['required', Rule::exists(ELetterTemplate::class, 'id')],
        // ]);

        try {
            $data = $this->eLetterSubmissionUserService->searchResidentByNationalID($request->input('e_letter_template_id'), $request->input('national_id'));

            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data penduduk tidak ditemukan, mohon lanjutkan dengan mengisi data penduduk secara manual.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil.',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            Log::error("Gagal mencari variable Surat by NIK:", ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem internal saat memproses data.',
                'data' => []
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ELetterSubmissionUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->eLetterSubmissionUserService->store($data);

            return redirect()
                ->route('user.e-letter.index')
                ->with('success', 'Data Surat berhasil diajukan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Submission Surat:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Pengajuan data gagal. Terjadi kesalahan internal.');
        }
    }
}

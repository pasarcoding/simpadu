<?php

namespace Modules\Contact\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Contact\App\Http\Requests\CritiqueSuggestionUserRequest;
use Modules\Contact\App\Http\Services\CritiqueSuggestionUserService;

class ContactUserController extends Controller
{
    protected $critiqueSuggestionUserService;

    public function __construct(CritiqueSuggestionUserService $critiqueSuggestionUserService)
    {
        $this->critiqueSuggestionUserService = $critiqueSuggestionUserService;
    }

    public function index()
    {
        return view('contact::user.index');
    }

    public function critique_suggestion(CritiqueSuggestionUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->critiqueSuggestionUserService->critique_suggestion($data);

            return redirect()
                ->route('user.contact.index')
                ->with('success', 'Data Kritik & Saran berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Kritik & Saran:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

}

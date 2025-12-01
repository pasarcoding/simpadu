<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Setting\App\Http\Requests\SettingAppearanceRequest;
use Modules\Setting\App\Http\Requests\SettingAppRequest;
use Modules\Setting\App\Http\Requests\SettingContactRequest;
use Modules\Setting\App\Http\Requests\SettingELetterRequest;
use Modules\Setting\App\Http\Services\SettingService;
use Modules\Setting\App\Models\Setting;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eLetterVariableMessage = $this->settingService->e_letter_parse_message();

        return view('setting::admin.index', [
            'eLetterVariableMessage' => $eLetterVariableMessage,
        ]);
    }

    public function app(SettingAppRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->settingService->app($data);

            return redirect()
                ->route('admin.setting.index')
                ->with('app_success', 'Data App berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update App:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('app_error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    public function appearance(SettingAppearanceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->settingService->appearance($data);

            return redirect()
                ->route('admin.setting.index')
                ->with('appearance_success', 'Data Tampilan berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Tampilan:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('appearance_error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    public function contact(SettingContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->settingService->contact($data);

            return redirect()
                ->route('admin.setting.index')
                ->with('contact_success', 'Data Kontak berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Kontak:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('contact_error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    public function e_letter(SettingELetterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->settingService->e_letter($data);

            return redirect()
                ->route('admin.setting.index')
                ->with('e_letter_success', 'Data Pesan Surat berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Pesan Surat:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('e_letter_error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }
}

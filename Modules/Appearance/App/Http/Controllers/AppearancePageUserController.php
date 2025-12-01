<?php

namespace Modules\Appearance\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Appearance\App\Models\AppearancePage;

class AppearancePageUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __invoke(AppearancePage $appearancePage)
    {
        return view('appearance::user.page.index', [
            'data' => $appearancePage,
        ]);
    }
}

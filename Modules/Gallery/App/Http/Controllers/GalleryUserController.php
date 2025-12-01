<?php

namespace Modules\Gallery\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Gallery\App\Http\Requests\GalleryRequest;
use Modules\Gallery\App\Http\Services\GalleryService;
use Modules\Gallery\App\Models\Gallery;

class GalleryUserController extends Controller
{

    public function __invoke()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();

        return view('gallery::user.index', [
            'galleries' => $galleries,
        ]);
    }
}

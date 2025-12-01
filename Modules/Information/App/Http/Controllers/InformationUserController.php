<?php

namespace Modules\Information\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Information\App\Models\Information;

class InformationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informations = Information::where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('information::user.index', [
            'informations' => $informations,
        ]);
    }

    public function show(Information $information)
    {
        $information->load('user');
        
        return view('information::user.detail', [
            'data' => $information,
        ]);
    }
}

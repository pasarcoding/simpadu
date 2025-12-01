<?php

namespace Modules\Product\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Product\App\Models\Product;

class ProductUserController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('product::user.index', [
            'products' => $products,
        ]);
    }

    public function show(Product $product)
    {
        return view('product::user.detail', [
            'data' => $product,
        ]);
    }
}

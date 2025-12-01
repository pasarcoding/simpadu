<?php

namespace Modules\Product\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Product\App\Http\Requests\ProductRequest;
use Modules\Product\App\Http\Services\ProductService;
use Modules\Product\App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->productService->get();
        }

        return view('product::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['slug'] = Str::slug($data['name']);

            $this->productService->store($data);

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Data Produk berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Produk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Product $product) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product::admin.edit', [
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->productService->update($product, $data);

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Data Produk berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Produk:", ['error' => $e->getMessage(), 'id' => $product->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->productService->destroy($product);

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Data Produk berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Produk:", ['error' => $e->getMessage(), 'id' => $product->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}

<?php

namespace Modules\Product\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    public function get()
    {
        $query = Product::select(['id', 'name', 'price', 'description', 'whatsapp_number', 'image'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('price', function ($row) {
                return rupiah_formatted($row->price);
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" class="rounded-3 object-fit-cover" style="width: 4rem; height: 4rem;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';

                if (auth()->user()->can(PermissionName::product_edit())) {
                    $btn .= ' <a href="' . route('admin.product.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::product_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.product.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newImage = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage = $data['image']->store('product', 'public');
            $data['image'] = $newImage;
        }

        DB::beginTransaction();
        try {
            $product = Product::create($data);

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function update(Product $product, $data)
    {
        $oldImage = $product->getRawOriginal('image');
        $newImage = null;

        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage = $data['image']->store('product', 'public');
            $data['image'] = $newImage;
        }

        DB::beginTransaction();
        try {
            $product->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function destroy(Product $product)
    {
        $image = $product->getRawOriginal('image');

        DB::beginTransaction();
        try {
            $delete = $product->delete();

            if ($delete && $image) {
                Storage::disk('public')->delete($image);
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

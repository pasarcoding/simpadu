<?php

namespace Modules\Budget\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Budget\App\Models\Budget;
use Modules\Budget\App\Models\ItemBudget;
use Modules\Gallery\App\Models\Gallery;
use Yajra\DataTables\Facades\DataTables;

class ItemBudgetService
{
    public function get(Budget $budget)
    {
        $query = ItemBudget::select(['id', 'nominal', 'type', 'note', 'payment_at'])
            ->where('budget_id', $budget->id)
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('type', function ($row) {
                return getItemBudgetTypeList()[$row->type];
            })
            ->editColumn('nominal', function ($row) {
                $colors = [
                    'in' => 'success',
                    'out' => 'danger',
                ];

                return '<span class="text-' . $colors[$row->type] . '">' . ($row->type == 'in' ? '+' : '-')  . rupiah_formatted($row->nominal) . '</span>';
            })
            ->editColumn('payment_at', function ($row) {
                return Carbon::parse($row->payment_at)->format('d F Y');
            })
            ->addColumn('action', function ($row) use ($budget) {
                $btn = '';

                if (auth()->user()->can(PermissionName::budget_detail_delete())) {
                    $btn .= '<button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.budget.detail.delete', ['budget' => $budget->id, 'itemBudget' => $row->id]) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['nominal', 'action'])
            ->make(true);
    }

    public function store(Budget $budget, $data)
    {
        $dataToInsert = [];
        $now = now();

        foreach ($data as $item) {
            $dataToInsert[] = [
                'budget_id' => $budget->id,
                'nominal' => $item['nominal'],
                'type' => $item['type'],
                'note' => $item['note'],
                'payment_at' => $item['payment_at'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();
        try {
            $itemBudget = ItemBudget::insert($dataToInsert);

            DB::commit();
            return $itemBudget;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(ItemBudget $itemBudget)
    {
        DB::beginTransaction();
        try {
            $delete = $itemBudget->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

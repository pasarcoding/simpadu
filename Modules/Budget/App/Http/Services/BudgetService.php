<?php

namespace Modules\Budget\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Budget\App\Models\Budget;
use Modules\News\App\Models\News;
use Yajra\DataTables\Facades\DataTables;

class BudgetService
{
    public function get()
    {
        $query = Budget::select(['id', 'title', 'account_name', 'bank_name', 'bank_number', 'type'])
            ->with('item_budget')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('bank', function ($row) {
                return '<div class="d-flex flex-column">'
                    . '<div>Nama: ' . $row->account_name . '</div>'
                    . '<div>Bank: ' . getBankList()[$row->bank_name] . '</div>'
                    . '<div>No. Rekening: ' . $row->bank_number . '</div>'
                    . '</div>';
            })
            ->addColumn('budget', function ($row) {
                return '<span class="text-success">' . rupiah_formatted($row->item_budget->where('type', 'in')->sum('nominal')) . '</span>';
            })
            ->addColumn('realization', function ($row) {
                return '<span class="text-danger">' . rupiah_formatted($row->item_budget->where('type', 'out')->sum('nominal')) . '</span>';
            })
            ->addColumn('grand_total', function ($row) {
                $in = $row->item_budget->where('type', 'in')->sum('nominal');
                $out = $row->item_budget->where('type', 'out')->sum('nominal');
                return rupiah_formatted($in - $out);
            })
            ->editColumn('type', function ($row) {
                $icons = [
                    'progress' => 'chart-donut-2',
                    'table' => 'table',
                ];

                return '<span><i class="ti ti-' . $icons[$row->type] . '"></i> ' . getBudgetTypeList()[$row->type] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::budget_detail_view())) {
                    $btn .= '<a href="' . route('admin.budget.detail.index', $row->id) . '" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-notebook"></i></a>';
                }

                if (auth()->user()->can(PermissionName::budget_edit())) {
                    $btn .= ' <a href="' . route('admin.budget.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::budget_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.budget.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['bank', 'budget', 'realization', 'type', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $budget = Budget::create($data);

            DB::commit();
            return $budget;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Budget $budget, $data)
    {
        DB::beginTransaction();
        try {
            $budget->update($data);

            DB::commit();
            return $budget;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Budget $budget)
    {
        DB::beginTransaction();
        try {
            $delete = $budget->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

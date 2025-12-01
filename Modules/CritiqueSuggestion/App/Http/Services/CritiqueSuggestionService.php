<?php

namespace Modules\CritiqueSuggestion\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\CritiqueSuggestion\App\Models\CritiqueSuggestion;
use Yajra\DataTables\Facades\DataTables;

class CritiqueSuggestionService
{
    public function get()
    {
        $query = CritiqueSuggestion::select(['id', 'name', 'phone', 'email', 'subject', 'content'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('content', function ($row) {
                return '<div class="d-flex flex-column">'
                    . '<div>Nama: <b>' . $row->name . '</b></div>'
                    . '<div>No.Hp/WA: <b>' . $row->phone . '</b></div>'
                    . '<div>Email: <b>' . $row->email . '</b></div>'
                    . '<div>Subjek: <b>' . $row->subject . '</b></div>'
                    . '<div class="mt-2">' . $row->content . '</div>'
                    . '</div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::critique_suggestion_delete())) {
                    $btn .= '<button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.critique-suggestion.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['content', 'action'])
            ->make(true);
    }

    public function destroy(CritiqueSuggestion $critiqueSuggestion)
    {
        DB::beginTransaction();
        try {
            $delete = $critiqueSuggestion->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

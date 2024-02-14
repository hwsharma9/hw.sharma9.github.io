<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ErrorLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (request()->ajax()) {
            $data = ErrorLog::query();
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->make(true);
        }

        return view('admin.error_logs.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AjaxMasterController extends Controller
{
    public function index()
    {
    }
    public function getModuleList(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'table' => [
                        'required',
                    ],
                    'key_column' => [
                        'required',
                        'exists:' . $request->table . ',' . $request->key,
                    ],
                    'value_colum' => 'required',
                ],
                [
                    'table.required' => 'Table name is required',
                    'key_column.required' => 'Table column is required',
                    'value_colum.required' => 'Value is required',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            $records = DB::table($request->table)->select($request->key_column, $request->value_colum)->get();
            $html = "<option value=''>--select--</option>";
            if ($records) {
                foreach ($records as $record) {
                    $html = "<option value='" . $record[$request->key_colum] . "'>" . $record[$request->value_colum] . "</option>";
                }
            }
            return response()->json(['status' => 'success', 'message' => $html], 200);
        }
    }
}

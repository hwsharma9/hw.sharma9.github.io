<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\FrontMenuModule;
use App\Http\Requests\Admin\StoreFrontMenuModuleRequest;
use App\Http\Requests\Admin\UpdateFrontMenuModuleRequest;
use Yajra\DataTables\Facades\DataTables;

class FrontMenuModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = FrontMenuModule::query();
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary" href="' . route('manage.permissions.edit', ['permission' => $row['id']]) . '"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.frontmenus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontmenus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFrontMenuModuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrontMenuModuleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FrontMenu  $frontMenu
     * @return \Illuminate\Http\Response
     */
    public function show(FrontMenu $frontMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FrontMenu  $frontMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(FrontMenu $frontMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFrontMenuModuleRequest  $request
     * @param  \App\Models\FrontMenu  $frontMenu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFrontMenuModuleRequest $request, FrontMenu $frontMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FrontMenu  $frontMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrontMenu $frontMenu)
    {
        //
    }

    public function getPages(Request $request)
    {
        // ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = FrontMenu::withTrashed()
            ->select('count(*) as allcount')->count();
        $totalRecordswithFilter = FrontMenu::withTrashed()
            ->select('count(*) as allcount')
            ->where('title_en', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = FrontMenu::withTrashed()
            ->orderBy($columnName, $columnSortOrder)
            ->where('title_en', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $records
        );
        return $response;
    }
}

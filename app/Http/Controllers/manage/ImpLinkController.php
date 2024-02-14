<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\DbControllerRoute;
use App\Models\ImpLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ImpLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = ImpLink::query();
            $actions = [
                'edit' => 'manage.implinks.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $action = view('components.admin.list-actions', [
                        'actions' => $actions,
                        'model' => $row,
                        'permissions' => $permissions,
                        'encrypt' => true
                    ]);
                    $action = $action->render();

                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.imp_links.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'title_hi' => 'required',
                'title_en' => 'required',
                'menu_type' => 'required',
                'status' => 'required',
                'fk_page_id' => ['required']
            ];
            $message = [
                'title_hi.required' => 'Title in Hindi is required',
                'title_en.required' => 'Title in English is required',
                'menu_type.required' => 'Menu Type is required'
            ];
            if ($request->has('menu_type') && $request->menu_type == 1) {
                $message['fk_page_id.required'] = 'The Page is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 2) {
                $message['fk_page_id.required'] = 'The Module is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 3) {
                array_push($rules['fk_page_id'], 'url');
                $message['fk_page_id.required'] = 'The Custom URL is Required';
                $message['fk_page_id.url'] = 'The Custom URL Must be a valid URL. Ex:- http://www.example.com';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
                $message
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            if ($validated['menu_type'] == 1) {
                $page_route = DbControllerRoute::where([
                    'named_route' => 'page.show',
                    'method' => 'get',
                    'function_name' => 'show'
                ])->first();
                $validated['fk_controller_route_id'] = $page_route->id;
            } elseif ($validated['menu_type'] == 2) {
                $validated['fk_controller_route_id'] = $validated['fk_page_id'];
                $validated['fk_page_id'] = null;
            } elseif (in_array($validated['menu_type'], [3, 4])) {
                $validated['custom_url'] = $validated['fk_page_id'];
                $validated['fk_controller_route_id'] = null;
                $validated['fk_page_id'] = null;
            }
            ImpLink::create($validated);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.implinks.index'))
                ->with('success', __('app.record_created'));
        }
        return view('admin.imp_links.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImpLink  $impLink
     * @return \Illuminate\Http\Response
     */
    public function show(ImpLink $impLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImpLink  $impLink
     * @return \Illuminate\Http\Response
     */
    public function edit(ImpLink $implink, Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'title_hi' => 'required',
                'title_en' => 'required',
                'menu_type' => 'required',
                'status' => 'required',
                'fk_page_id' => ['required']
            ];
            $message = [
                'title_hi.required' => 'Title in Hindi is required',
                'title_en.required' => 'Title in English is required',
                'menu_type.required' => 'Menu Type is required',
            ];
            if ($request->has('menu_type') && $request->menu_type == 1) {
                $message['fk_page_id.required'] = 'The Page is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 2) {
                $message['fk_page_id.required'] = 'The Module is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 3) {
                array_push($rules['fk_page_id'], 'url');
                $message['fk_page_id.required'] = 'The Custom URL is Required';
                $message['fk_page_id.url'] = 'The Custom URL Must be a valid URL. Ex:- http://www.example.com';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
                $message
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();

            if ($validated['menu_type'] == 1) {
                $page_route = DbControllerRoute::where([
                    'named_route' => 'page.show',
                    'method' => 'get',
                    'function_name' => 'show'
                ])->first();
                $validated['fk_controller_route_id'] = $page_route->id;
            } elseif ($validated['menu_type'] == 2) {
                $validated['fk_controller_route_id'] = $validated['fk_page_id'];
                $validated['fk_page_id'] = null;
            } elseif (in_array($validated['menu_type'], [3, 4])) {
                $validated['custom_url'] = $validated['fk_page_id'];
                $validated['fk_controller_route_id'] = null;
                $validated['fk_page_id'] = null;
            }

            $implink->fill($validated);
            $implink->save();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.implinks.index'))
                ->with('success', __('app.record_updated'));
        }
        return view('admin.imp_links.edit', compact('implink'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImpLink  $impLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImpLink $impLink)
    {
        //
    }
}

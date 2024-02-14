<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Http\Services\GateAllow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Page::query();
            $actions = [
                'edit' => 'manage.pages.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $action = view('components.admin.list-actions', [
                        'actions' => $actions,
                        'model' => $row,
                        'permissions' => $permissions
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
                ->editColumn('is_default', function ($row) {
                    return DefaultStatus($row['is_default']);
                })
                ->rawColumns(['action', 'status', 'is_default'])
                ->make(true);
        }
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'slug' => 'string|unique:tbl_pages',
                'title_hi' => 'required|min:2|max:255|unique:tbl_pages',
                'description_hi' => 'required|min:2',
                'title_en' => 'required|min:2|max:255|unique:tbl_pages',
                'description_en' => 'required|min:2',
                'meta_title' => 'nullable|max:200',
                'meta_keyword' => 'nullable|max:200',
                'meta_description' => 'nullable|max:200',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            $validated['slug'] = Str::slug($request->title_en);
            Page::create($validated);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.pages.index'))
                ->with('success', __('app.record_created'));
        }
        return view('admin.pages.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Page $page)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'slug' => ['string', Rule::unique('tbl_pages')->ignore($page->id)],
                'title_hi' => ['required', 'min:2', 'max:255', Rule::unique('tbl_pages')->ignore($page->id)],
                'description_hi' => 'required|min:2',
                'title_en' => ['required', 'min:2', 'max:255', Rule::unique('tbl_pages')->ignore($page->id)],
                'description_en' => 'required|min:2',
                'status' => 'required',
                'meta_title' => 'nullable|max:200',
                'meta_keyword' => 'nullable|max:200',
                'meta_description' => 'nullable|max:200',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $page->fill($validator->validated());
            $page->save();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.pages.index'))
                ->with('success', __('app.record_updated'));
        }
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Http\Services\GateAllow;
use App\Models\DbControllerRoute;
use App\Models\SliderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = 'Top Slider')
    {
        $fk_slider_category_id = 2;
        if ($type = 'Top Slider') {
            $fk_slider_category_id = 1;
        }
        if (request()->ajax()) {
            $data = Slider::query()
                ->where('fk_slider_category_id', $fk_slider_category_id)
                ->with([
                    'editor',
                    'creator',
                ]);
            $actions = [
                'edit' => 'manage.sliders.edit',
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
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));;
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.sliders.index', compact('fk_slider_category_id', 'type'));
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
                'fk_slider_category_id' => 'required',
                'fk_page_id' => ['required']
            ];
            $message = [
                'title_hi.required' => 'Title in Hindi is required',
                'title_en.required' => 'Title in English is required',
                'menu_type.required' => 'Menu Type is required',
                'fk_slider_category_id.required' => 'Slider Category is required'
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
            // return [
            //     $validated,
            //     $request->file()
            // ];
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
            $slider = Slider::create($validated);
            $slider->uploadModelFile($slider);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.sliders.index', $request->type))
                ->with('success', __('app.record_created'));
        }
        $slider_categories = SliderCategory::get()->pluck('id', 'cat_title_en');
        $type = $request->get('type');
        return view('admin.sliders.create', compact('slider_categories', 'type'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider, Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'title_hi' => 'required',
                'title_en' => 'required',
                'menu_type' => 'required',
                'fk_page_id' => ['required'],
                'status' => 'required',
            ];
            $message = [
                'title_hi.required' => 'Title in Hindi is required',
                'title_en.required' => 'Title in English is required',
                'menu_type.required' => 'Menu Type is required',
                'status.required' => 'Status is required',
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

            if (request()->file()) {
                foreach (request()->file() as $file_input_name => $file) {
                    if (request()->hasFile($file_input_name)) {
                        $image = $slider->upload()->where('field_name', $file_input_name)->first();
                        if ($image) {
                            // delete the old image from storage and database.
                            $image->delete();
                        }
                    }
                }
            }

            $slider->fill($validated);
            $slider->save();
            $slider->uploadModelFile($slider);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.sliders.index', $request->type))
                ->with('success', __('app.record_updated'));
        }
        $slider_categories = SliderCategory::get()->pluck('cat_title_en', 'id');
        $type = $request->get('type');
        $uploads = $slider->uploads->pluck('file_path', 'field_name');
        // return $uploads;
        return view('admin.sliders.edit', compact('slider_categories', 'type', 'slider', 'uploads'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Media::query()
                ->with([
                    'creator',
                    'editor',
                    'upload' => function ($query) {
                        $query->select(
                            "id",
                            "uploadable_type",
                            "uploadable_id",
                            "original_name",
                        );
                    }
                ]);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('created_by', function ($row) {
                    return $row['creator']['first_name'] . ' ' . $row['creator']['last_name'];
                })
                ->editColumn('updated_by', function ($row) {
                    return $row['editor']['first_name'] . ' ' . $row['editor']['last_name'];
                })
                ->rawColumns(['action', 'created_by', 'updated_by', 'link'])
                ->make(true);
        }
        return view('admin.medias.index');
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
                'file' => 'required|mimes:pdf,doc,docx,jpeg,jpg,JPG,JPEG,png,pdf,xls,xlsx,mp4|max:10240',
            ]);

            if ($validator->fails()) {
                return [
                    "message" => "The given data was invalid.",
                    "errors" => $validator->errors()
                ];
            }

            $media = Media::create($validator->validated());
            $media->uploadModelFile($media);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.medias.index'))
                ->with('success', 'Profile Image Uploaded Successfully');
        }
        return view('admin.medias.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media, Request $request)
    {
        $upload = $media->upload;
        $message = $upload->original_name  . " Restored successully!";
        if ($request->has('restore') && $request->restore == 1) {
            $media->restore();
        } else {
            if ($media->deleteOrFail() === false) {
                return response(
                    ["message" => "Couldn't delete the media with id {$media->id}", "action" => false],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $message = $upload->original_name  . " softly deleted successully!";
        }

        return response(["message" => $message, "action" => true], Response::HTTP_OK);
    }
}

<x-admin-layout>
    @push('styles')
        <style>
            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 50px;
                padding: 0 10px;
            }

            .img-bg {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                position: relative;
                padding-bottom: 100%;
            }

            .upload-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid #ced4da;
                margin-bottom: 10px;
                padding: 10px 10px;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('webroot/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @endpush
    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            {{-- <a href="{{ route('manage.course.remark.create', ['course' => $course->id]) }}"
                                class="btn btn-primary"><i class="fa fa-plus"></i> Add Remark</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="content">
        @php
            $course_media = $course->uploads->whereNull('deleted_at')->first();
            $has_request = $course->requests->count() > 0;
            // echo '<pre>';
            // print_r($course->requests->toArray());
            // print_r($course->uploads->whereNull('deleted_at')->first());
            // echo '</pre>';
            // $log = '';
            // if ($course->course_status == 2 && $course->is_edited == 1) {
            //     $log = $course->logs()->whereNotNull('prev_data')->where('course_status', 2)->latest()->first();
            // print_r($log);
            // print_r($course->checkDiff($log));
            // }
        @endphp
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('View Course') }}
            </x-slot>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="fk_course_category_id">Category <span class="text-danger">*</span></x-label>
                            <input class="form-control"
                                value="{{ $course->assignedAdmin->courseCategory->category_name_en }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="fk_course_category_id">Course</x-label>
                            <input class="form-control"
                                value="{{ $course->assignedAdmin->categoryCourse->course_name_en }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="description">Course Description <span class="text-danger">*</span>
                                @if ($has_request && $course->course_status >= 2)
                                    {!! $course->checkDiff('description') !!}
                                @endif
                            </x-label>
                            {{-- <textarea type="text" name="description" class="form-control" id="description"
                            placeholder="Enter Course Description">{{ old('description', $course->description) }}</textarea> --}}
                            <div class="form-control" style="height: auto;">
                                {!! $course->update_description ? $course->update_description : $course->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 upload-file">
                        <div class="d-flex">
                            <div class="col-md-12 upload-file">
                                <label>Course Thumbnail @if ($has_request && $course->course_status >= 2 && $course->uploads->where('course_status', '!=', 2)->count())
                                        {!! $course->upload->checkCourseDiff($course->uploads, 'course_thumbnail') !!}
                                    @endif
                                </label>
                                <div class="form-group">
                                    @if ($course_media)
                                        <a
                                            href="{{ route('manage.download-media', ['media' => encrypt($course_media->id)]) }}">
                                            <div class="upload-row mp-1">
                                                <div class="upload__img-wrap">
                                                    <div class="upload__img-box">
                                                        <div style="background-image: url({{ $course_media->file_path }})"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="{{ $course_media->original_name }}" class="img-bg">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{ $course_media->original_name }}
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="topics_container">
                    @if ($course->topics)
                        @foreach ($course->topics as $topic)
                            @php
                                $course_pdfs = $topic->uploads->where('field_name', 'course_pdf')->all();
                                $course_ppts = $topic->uploads->where('field_name', 'course_ppt')->all();
                                $course_docs = $topic->uploads->where('field_name', 'course_doc')->all();
                                $course_video = $topic->uploads->where('field_name', 'course_video')->first();
                            @endphp
                            <div class="col-md-12 topic_html">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool bg-info"
                                                data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Topic Title Start -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="topic_title">Topic Title <span
                                                            class="text-danger">*</span>
                                                        @if ($has_request && $topic->course_status >= 2)
                                                            {!! $topic->checkDiff('title') !!}
                                                        @endif
                                                    </label>
                                                    <input type="text"
                                                        value="{{ $topic->update_title ? $topic->update_title : $topic->title }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <!-- Topic Title End -->
                                            <!-- Video URL Start -->
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <label>Video URL
                                                        @if ($has_request && $topic->course_status >= 2)
                                                            {!! $course_video?->checkCourseVideoDiff() !!}
                                                        @endif
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            value="{{ $course_video?->update_file_path ? $course_video?->update_file_path : $course_video?->file_path }}"
                                                            placeholder="upload video on youtube and type the youtube video link here">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Video URL End -->
                                            <!-- Topic Summary Start -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="topic_summary">Topic Summary @if ($has_request && $topic->course_status >= 2)
                                                            {!! $topic->checkDiff('summary') !!}
                                                        @endif
                                                    </label>
                                                    <div class="form-control">{!! $topic->update_summary ? $topic->update_summary : $topic->summary !!}</div>
                                                </div>
                                            </div>
                                            <!-- Topic Summary End -->
                                            <!-- Download PDF Start -->
                                            <div class="col-md-6">
                                                <div class="col-md-12 upload-file">
                                                    <label>Download PDF @if (
                                                        $has_request &&
                                                            $course_pdfs &&
                                                            $topic->course_status >= 2 &&
                                                            (collect($course_pdfs)->where('course_status', '!=', 2)->count() ||
                                                                collect($course_pdfs)->whereNotNull('deleted_at')->count()))
                                                            {!! $topic->upload->checkCourseDiff(collect($course_pdfs), 'course_pdf') !!}
                                                        @endif
                                                    </label>
                                                    <div class="form-group">
                                                        @if ($course_pdfs)
                                                            @foreach ($course_pdfs as $course_pdf)
                                                                @if (!$course_pdf->trashed())
                                                                    <a
                                                                        href="{{ route('manage.download-media', ['media' => encrypt($course_pdf->id)]) }}">
                                                                        <div class="upload-row mp-1">
                                                                            <div class="upload__img-wrap">
                                                                                <div class="upload__img-box">
                                                                                    <div style="background-image: url({{ asset('dist/img/pdf.png') }})"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="{{ $course_pdf->original_name }}"
                                                                                        class="img-bg">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{ $course_pdf->original_name }}
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if (collect($course_pdfs)->whereNull('deleted_at')->count() == 0)
                                                            <div class="upload-row mp-1">
                                                                <h5>No File uploaded!</h5>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Download PDF End -->
                                            <!-- Download PPT Start -->
                                            <div class="col-md-6">
                                                <div class="col-md-12 upload-file">
                                                    <label>Download PPT @if (
                                                        $has_request &&
                                                            $course_ppts &&
                                                            $topic->course_status >= 2 &&
                                                            (collect($course_ppts)->where('course_status', '!=', 2)->count() ||
                                                                collect($course_ppts)->whereNotNull('deleted_at')->count()))
                                                            {!! $topic->upload->checkCourseDiff(collect($course_ppts), 'course_ppt') !!}
                                                        @endif
                                                    </label>
                                                    <div class="form-group">
                                                        @if ($course_ppts)
                                                            @foreach ($course_ppts as $course_ppt)
                                                                @if (!$course_ppt->trashed())
                                                                    <a
                                                                        href="{{ route('manage.download-media', ['media' => encrypt($course_ppt->id)]) }}">
                                                                        <div class="upload-row mp-1">
                                                                            <div class="upload__img-wrap">
                                                                                <div class="upload__img-box">
                                                                                    <div style="background-image: url({{ asset('dist/img/ppt.png') }})"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="{{ $course_ppt->original_name }}"
                                                                                        class="img-bg">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{ $course_ppt->original_name }}
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if (collect($course_ppts)->whereNull('deleted_at')->count() == 0)
                                                            <div class="upload-row mp-1">
                                                                <h5>No File uploaded!</h5>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Download PDF End -->
                                            <!-- Download DOC Start -->
                                            <div class="col-md-6">
                                                <div class="col-md-12 upload-file">
                                                    <label>Download DOC @if (
                                                        $has_request &&
                                                            $course_docs &&
                                                            $topic->course_status >= 2 &&
                                                            (collect($course_docs)->where('course_status', '!=', 2)->count() ||
                                                                collect($course_docs)->whereNotNull('deleted_at')->count()))
                                                            {!! $topic->upload->checkCourseDiff(collect($course_docs), 'course_doc') !!}
                                                        @endif
                                                    </label>
                                                    <div class="form-group">
                                                        @if ($course_docs)
                                                            @foreach ($course_docs as $course_doc)
                                                                @if (!$course_doc->trashed())
                                                                    <a
                                                                        href="{{ route('manage.download-media', ['media' => encrypt($course_doc->id)]) }}">
                                                                        <div class="upload-row mp-1">
                                                                            <div class="upload__img-wrap">
                                                                                <div class="upload__img-box">
                                                                                    <div style="background-image: url({{ asset('dist/img/doc.png') }})"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="{{ $course_doc->original_name }}"
                                                                                        class="img-bg">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{ $course_doc->original_name }}
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if (collect($course_docs)->whereNull('deleted_at')->count() == 0)
                                                            <div class="upload-row mp-1">
                                                                <h5>No File uploaded!</h5>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Download DOC End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                @if (Gate::allows('check-auth', 'manage.course.request.index'))
                    @if ($course->requests->count())
                        <button type="butotn" class="btn btn-secondary" id="add-remark">Action</button>
                    @endif
                @endif
            </div>
        </x-admin.container-card>
        <div class="modal fade" id="remark-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Remarks</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                            {{-- <th>Updated Topics</th> --}}
                                            <th>Last Modified By</th>
                                            <th>Last Modified On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        @if ($has_request)
                            <form
                                action="{{ route('manage.course.request.edit', ['course' => $course->id, 'approval_request' => $course->requests[0]->id]) }}"
                                data-action="{{ route('manage.course.request.edit', ['course' => $course->id, 'approval_request' => $course->requests[0]->id]) }}"
                                method="POST" name="add-remark" id="addremarkform">
                                @csrf
                                <input type="hidden" name="status" value="{{ $course->requests[0]->status }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-label for="remark">Remark</x-label>
                                            <textarea name="remark" cols="30" rows="10" class="form-control"
                                                @if ($course->requests[0]->status > 0) disabled @endif>{{ $course->requests[0]->remark }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row" @if ($course->requests[0]->status == 2) style="display:none" @endif>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-label for="status">Request Status <span
                                                    class="text-danger">*</span></x-label>
                                            <select name="status" class="form-control"
                                                @if ($course->requests[0]->status == 2) disabled @endif>
                                                <option value="1"
                                                    {{ in_array($course->requests[0]->status, [0, 1]) ? 'selected' : '' }}>
                                                    Send for
                                                    Correction</option>
                                                <option value="2"
                                                    {{ $course->requests[0]->status == 2 ? 'selected' : '' }}>Approved
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary set_status" data-val="1">Send for
                                        Correction</button>
                                    <button type="submit" class="btn btn-success set_status"
                                        data-val="2">Approved</button>
                                    {{-- <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"
                                        @if ($course->requests[0]->status == 2) disabled @endif>Submit</button> --}}
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="check-diff-model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Changes</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row flex flex-row" id="show-changed">
                            <div class="col-md-6">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Approvel Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="approved-model"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Changed Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="changed-model"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    @push('scripts')
        <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        @if (Gate::allows('check-auth', 'manage.course.request.index'))
            <script type="text/javascript">
                $(function() {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    var table = $('#dataTable').DataTable({
                        processing: true,
                        serverSide: false,
                        searching: false,
                        ajax: {
                            url: "{{ route('manage.course.request.index', ['course' => $course->id]) }}",
                            data: function(d) {
                                const search_data = {}
                                $("#search_form").serializeArray()
                                    .filter(row => row.value != "")
                                    .forEach(row => {
                                        search_data[row.name] = row.value;
                                    });
                                d.filter = search_data;
                            }
                        },
                        autoWidth: false,
                        order: [0, 'desc'],
                        columns: [{
                                data: row => row.DT_RowIndex,
                                name: 'id'
                            },
                            {
                                data: 'course.assigned_admin.category_course.course_name_en',
                                name: 'course.assignedAdmin.categoryCourse.course_name_en'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            // {
                            //     data: 'updated_topics',
                            //     name: 'updated_topics'
                            // },
                            {
                                data: 'editor_name',
                                name: 'editor.first_name',
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                    });

                    $('#addremarkform button[type="submit"]').on("click", function(e) {
                        e.preventDefault();
                        $('#addremarkform input[name="status"]').val($(this).attr('data-val'));
                        $('#addremarkform').submit();
                    })

                    var remark_validator = jQuery("#addremarkform").validate({
                        rules: {
                            remark: {
                                required: true
                            },
                        },
                        messages: {
                            remark: {
                                required: 'Remark is required.',
                                maxlength: 250
                            },
                        },
                        submitHandler: function(form) {
                            $(document).ready(function() {
                                let status_value = form.status.value;
                                if (status_value == 2) {
                                    let confirmation = confirm(
                                        "Really want to approve this remark? After this you won't be able to edit the remark!"
                                    );
                                    if (!confirmation) {
                                        return;
                                    }
                                } else {
                                    $('#addremarkform button[type="submit"]').prop('disabled', true);
                                }

                                $.ajax({
                                    url: $(form).attr('action'),
                                    data: $(form).serialize(),
                                    success: function(data) {
                                        if (data.status == true) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: data.message
                                            });
                                            location.reload();
                                        }
                                    },
                                    error: function(error) {
                                        console.log(error);
                                        location.reload();
                                    },
                                });
                            });
                        }
                    });

                    $("#add-remark").on("click", function() {
                        $("#remark-modal").modal("show");
                        const status = $('#addremarkform input[name="status"]').val();
                        if (status == 0) {
                            $('#addremarkform .modal-footer').show();
                        } else {
                            $('#addremarkform .modal-footer').hide();
                        }
                        table.ajax.reload();
                    });

                    $(document).on("click", ".view-remark", function(e) {
                        const url = $(this).attr('data-url');
                        const remark = $(this).attr('data-remark');
                        const status = $(this).attr('data-status');
                        $('form[name="add-remark"] textarea[name="remark"]').val(remark);
                        // $('form[name="add-remark"] input[name="status"]').closest(".row").hide();
                        // $('form[name="add-remark"] input[name="status"]').prop("disabled", true);
                        if (status == 0) {
                            $('form[name="add-remark"] .modal-footer').show();
                        } else {
                            $('form[name="add-remark"] .modal-footer').hide();
                        }
                        // $('form[name="add-remark"] button[type="submit"]').prop("disabled", true);
                        $('form[name="add-remark"] textarea[name="remark"]').prop("disabled", true);
                    });
                    $(document).on("click", ".edit-remark", function(e) {
                        e.preventDefault();
                        const url = $(this).attr('data-url');
                        const remark = $(this).attr('data-remark');
                        let status = $(this).attr('data-status');
                        console.log('status => ', status);
                        if (status == 0) {
                            $('form[name="add-remark"] .modal-footer').show();
                            $('form[name="add-remark"] textarea[name="remark"]').prop('disabled', false);
                        } else {
                            $('form[name="add-remark"] .modal-footer').hide();
                            $('form[name="add-remark"] textarea[name="remark"]').prop('disabled', true);
                        }
                        $('form[name="add-remark"]').attr('action', url);
                        $('form[name="add-remark"] textarea[name="remark"]').val(remark);
                        $('form[name="add-remark"] input[name="status"]').val(status);
                    });
                });
            </script>
        @endif
        <script>
            var convert = (function() {
                // this prevents any overhead from creating the object each time
                var element = document.createElement('div');

                function decodeHTMLEntities(str) {
                    if (str && typeof str === 'string') {
                        // strip script/html tags
                        str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
                        str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
                        element.innerHTML = str;
                        str = element.textContent;
                        element.textContent = '';
                    }
                    return str;
                }

                return decodeHTMLEntities;
            })();

            function image(files) {
                let result = [];
                if (files.length) {
                    result = files.map(file => {
                        if (file) {
                            let image = '';
                            let mime_type = file.hasOwnProperty('file_mime_type') ? file.file_mime_type : file.type;
                            let asset = '{{ asset('') }}';
                            if (mime_type.match('image.*')) {
                                if (file.hasOwnProperty('file_mime_type')) {
                                    image = file.file_path;
                                } else {
                                    image = e.target.result;
                                }
                            } else if (mime_type.match('application/pdf')) {
                                image = asset + 'dist/img/pdf.png';
                            } else if (mime_type.match('video.*')) {
                                image = asset + 'dist/img/video.png';
                            } else if (['application/vnd.ms-powerpoint',
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                                ].includes(mime_type)) {
                                image = asset + 'dist/img/ppt.png';
                            } else if (['application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                ].includes(mime_type)) {
                                image = asset + 'dist/img/doc.png';
                            }
                            return String(`<div class="border p-2">
                                ${file.deleted_at ? '<label>Deleted</label>' : ''}
                                <div>
                                    <img src="${image}" width="50px" />
                                    ${file.original_name}
                                </div>
                            </div>`);
                        }
                    });
                } else {
                    result.push(String(`<div>
                            <label>Not Uploaded Yet!</label>
                        `));
                }
                return result.join('');
            }
            $(document).on("click", ".content-changed", function() {
                const column = $(this).attr('data-column');
                const is_file = $(this).attr('data-file');
                let approved = $(this).attr('data-approved');
                let approved_html = '';
                let changed = $(this).attr('data-changed');
                let changed_html = '';
                $("#approved-model").html('');
                $("#changed-model").html('');
                if (is_file) {
                    approved = approved ? JSON.parse(approved) : '';
                    approved_html = image(approved);
                    changed = changed ? JSON.parse(changed) : [];
                    changed_html = image(changed);
                    $("#approved-model").html(approved_html);
                    $("#changed-model").html(changed_html);
                } else {
                    approved_html = convert(approved);
                    changed_html = convert(changed);
                    $("#approved-model").html(approved);
                    $("#changed-model").html(changed);
                }
                $("#check-diff-model").modal('show');
            });
        </script>
    @endpush
</x-admin-layout>

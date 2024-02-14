<x-admin-layout>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <style>
            .upload__inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }

            .upload__btn {
                display: inline-block;
                font-weight: 600;
                color: #fff;
                text-align: center;
                min-width: 116px;
                padding: 5px;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid;
                background-color: #4045ba;
                border-color: #4045ba;
                border-radius: 10px;
                line-height: 26px;
                font-size: 14px;
            }

            .upload__btn:hover {
                background-color: unset;
                color: #4045ba;
                transition: all 0.3s ease;
            }

            .upload__btn-box {
                margin-bottom: 10px;
            }

            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 70px;
                padding: 0 10px;
                margin-bottom: 10px;
            }

            .upload__img-close,
            .upload__img-trash {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                /* background-color: rgba(0, 0, 0, 0.5); */
                position: absolute;
                top: 0px;
                right: 0px;
                text-align: center;
                line-height: 8px;
                z-index: 1;
                cursor: pointer;
            }

            .upload__img-close:after {
                font-size: 8px;
                color: white;
            }

            .upload__img-trash:after {
                font-size: 8px;
                color: white;
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
                border: 1px solid gray;
                margin-top: 1px;
                padding-left: 2px;
                padding-right: 2px;
            }
        </style>
    @endpush
    <x-slot name="page_title">
        @php
            $medias = $course->uploads->toJson();
        @endphp
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if ($course->requests->count())
                                <button type="butotn" class="btn btn-secondary" id="show-remark">Show Remark</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $action = view('components.admin.course.topic', [
            'configuration' => $configuration ?? null,
            'topic' => null,
            'loop' => null,
        ])->render();
    @endphp
    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Edit Course') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.courses.edit', ['course' => encrypt($course->id), 'fk_course_category_courses_id' => encrypt($course->assignedAdmin->fk_course_category_courses_id)]) }}"
                enctype="multipart/form-data" id="quickForm">
                @csrf
                <input type="hidden" name="replaced_media_id">
                <input type="hidden" name="saved_as">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label>Category <span class="text-danger">*</span></x-label>
                            <input class="form-control" disabled
                                value="{{ $alloted_admin->courseCategory->category_name_en }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label>Course</x-label>
                            <input class="form-control" disabled
                                value="{{ $alloted_admin->categoryCourse->course_name_en }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="description">Course Description <span class="text-danger">*</span></x-label>
                            <textarea type="text" name="description" class="form-control ckeditor" id="course_description"
                                placeholder="Enter Course Description">{{ old('description', $course->update_description ? $course->update_description : $course->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 upload-file">
                        <div class="d-flex">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Course Thumbnail</legend>
                                <div class="form-group">
                                    @if ($course->upload)
                                        <div class="upload-row mp-1">
                                            <input type="file" name="course_thumbnail" class="course_thumbnail"
                                                id="course_thumbnail" data-files="{{ $course->upload }}"
                                                data-id="{{ encrypt($course->upload->id) }}"
                                                accept="image/png, image/jpeg" />
                                            <div class="upload__img-wrap"></div>
                                            <button type="button" class="btn btn-danger delete_upload_row"
                                                data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course->upload->id)]) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="upload-row mp-1">
                                            <input type="file" name="course_thumbnail" class="course_thumbnail"
                                                id="course_thumbnail" accept="image/png, image/jpeg" />
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="row" id="topics_container">
                    @if ($course->topics->count())
                        @foreach ($course->topics as $topic)
                            @php
                                $html = view('components.admin.course.topic', [
                                    'configuration' => $configuration ?? null,
                                    'topic' => $topic,
                                    'loop' => $loop,
                                ])->render();
                                echo $html;
                            @endphp
                        @endforeach
                    @else
                        @php
                            echo $action;
                        @endphp
                    @endif
                </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <x-admin.status-dropdown :selected="$course->status" />
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>
                        {{-- <x-admin.form-actions :actions="[
                            'update' => true,
                        ]" /> --}}
                        <button type="submit" class="btn btn-success" name="action" value="request">Request to
                            Approve</button>
                        <button type="submit" class="btn btn-primary" name="action" value="draft">Save as
                            Draft</button>
                    </span>
                    <span>
                        <button type="button" class="btn btn-secondary" id="add_topic">Add More Topics</button>
                    </span>
                </div>
            </form>
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
                                            <th>Last Modified By</th>
                                            <th>Last Modified On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-label for="remark">Remark</x-label>
                                    <textarea id="remark" cols="30" rows="10" class="form-control" disabled></textarea>
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

        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            function reinitCKIntances() {
                $("textarea.ckeditor").each((e, a) => {
                    var instance = CKEDITOR.instances[a.id];
                    if (instance) {
                        CKEDITOR.remove(instance);
                        instance.destroy(true);
                        instance = null;
                    }
                    initCK(a.id);
                });
            }

            function initCK(id) {
                CKEDITOR.replace(id, {
                    toolbar: [{
                            name: "basicstyles",
                            items: [
                                "Bold",
                                "Italic",
                                "Underline",
                                "Strike",
                                "Subscript",
                                "Superscript",
                                "-",
                                "RemoveFormat",
                            ],
                        },
                        {
                            name: "paragraph",
                            items: [
                                "NumberedList",
                                "BulletedList",
                                "-",
                                "Outdent",
                                "Indent",
                                "-",
                                "Blockquote",
                                "CreateDiv",
                                "-",
                                "JustifyLeft",
                                "JustifyCenter",
                                "JustifyRight",
                                "JustifyBlock",
                            ],
                        },
                    ],
                    language: "en",
                    width: "100%",
                    height: "200px",
                });
            }

            function loadEditors() {
                var $editors = $("textarea.ckeditor");
                if ($editors.length) {
                    $editors.each(function() {
                        var editorID = $(this).attr("id");
                        var instance = CKEDITOR.instances[editorID];
                        if (instance) {
                            console.log('destroy');
                            instance.destroy(true);
                        }

                    });
                }
            }

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
                $("#show-remark").on("click", function() {
                    $("#remark-modal").modal("show");
                    $("#remark").closest('.row').hide();
                    $("#remark").val('');
                    table.ajax.reload();
                });
                $(document).on("click", ".view-remark", function() {
                    $("#remark").closest('.row').show();
                    $("#remark").val($(this).attr('data-remark'));
                });
            });
        </script>
    @endpush
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });

                function countUploadRows(element) {
                    let file_box = $(element).closest('.form-group').find('.upload-row');
                    return !(file_box.length > 2);
                }
                jQuery.validator.addMethod("limit_file_upload", function(value, element) {
                    // console.log(element);
                    // let file_box = $(element).closest(".upload-file").find(
                    //     ".upload__img-wrap .upload__img-box");
                    let file_box = $(element).closest('.form-group').find('.upload-row');
                    // console.log('limit_file_upload => ', !(file_box.length > 2));
                    return !(file_box.length > 2);
                }, "You can upload up to 2 files for each topic.");

                jQuery.validator.addMethod("validate_file_size", function(value, element) {
                    let is_fine = true;
                    let files = document.getElementById(element.id).files;
                    if (files.length) {
                        for (const key in files) {
                            if (Object.hasOwnProperty.call(files, key)) {
                                const element = files[key];
                                if (element.size > 2097152) {
                                    is_fine = false;
                                };
                            }
                        }
                    }
                    return is_fine;
                }, "File size must be up to 2 MB.");

                function formSubmit(route, data, is_files_uploaded) {

                    $.ajax({
                        type: "POST",
                        url: route,
                        data: data,
                        cache: false,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function(data) {
                            $(".ss-validation").remove();
                            if (data.captcha) {
                                $('input[name=captcha]').val('');
                                $('.captcha-image').attr('src', data.captcha);
                            }
                            if (data.status == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });

                                // If any file is uploaded reload the page.
                                // Issue is we will need to update course_video_id of each topic 
                                // if (is_files_uploaded) {}
                                location.reload();
                            } else {
                                $("#quickForm").closest('.card-body').prepend(data
                                    .errors);
                                $("html, body").animate({
                                    scrollTop: 0
                                }, 500);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }

                var validator = jQuery("#quickForm").validate({
                    ignore: [],
                    // debug: false,
                    rules: {
                        description: {
                            required: true,
                        },
                        captcha: {
                            required: false,
                        },
                    },
                    messages: {
                        captcha: {
                            required: 'Description is required.',
                            maxlength: 250
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    errorPlacement: function(error, element) {
                        // console.log('element name => ', element.attr("name"));
                        console.log('element => ', element.prop('localName'));
                        if (
                            element.attr("name").includes('[course_pdf][]') ||
                            element.attr("name").includes('[course_ppt][]') ||
                            element.attr("name").includes('[course_doc][]')
                        ) {
                            error.insertAfter($(element).closest('.form-group'));
                        }
                        /*else if (element.prop('localName') === 'textarea') {
                                                   console.log('here');
                                                   error.insertAfter($('#cke_' + element.attr('id')));
                                               }*/
                        else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        $(document).ready(function() {
                            if ($('input[name="saved_as"]').attr('value') == 'draft') {
                                let route = $(form).attr('action');
                                let data = $(form).serializeArray();
                                var fd = new FormData();
                                data.forEach(d => fd.append(d.name, d.value))
                                let is_files_uploaded = false;
                                $('input[type="file"]').each(function(e) {
                                    let file = document.getElementById($(this).attr('id'))
                                        .files;
                                    if (file.length) {
                                        fd.append($(this).attr('name'), file[0]);
                                        is_files_uploaded = true;
                                    }
                                });
                                formSubmit(route, fd, is_files_uploaded);
                            } else {
                                let confirmation = confirm(
                                    "Really want to submit this course to be approved?");
                                if (confirmation) {
                                    loader.show();
                                    form.submit();
                                }
                            }
                        });
                    }
                });

                $('button[name="action"]').on("click", function() {
                    $('input[name="saved_as"]').val($(this).attr('value'));
                });

                function AddRemoveReplacedMediaId(id) {
                    id = String(id);
                    let replaced_media_id = $('input[name="replaced_media_id"]');
                    let input_ids = replaced_media_id.val();
                    input_ids = (input_ids == '') ? [] : input_ids.split(',');
                    if (input_ids.includes(id)) {
                        input_ids.splice(input_ids.indexOf(id), 1);
                    } else {
                        input_ids.push(id);
                    }
                    replaced_media_id.val(input_ids.join(','))
                }

                $(document).ready(function() {
                    updateTopicCount();
                    $('input[type="file"]').each(function(e) {
                        let target = $(this)[0];
                        let input_id = $(target).attr('id');
                        let img_wrap = $(target).siblings('.upload__img-wrap');
                        if ($(target).attr('data-files')) {
                            let file = JSON.parse($(target).attr('data-files'));
                            // console.log(file);

                            let image = ''
                            if (file.file_mime_type.match('image.*')) {
                                image = window.location.origin + '/storage/' + file
                                    .file_path.replace(
                                        /\\/g, "/");
                            } else if (file.file_mime_type.match('application/pdf')) {
                                image =
                                    "{{ asset('dist/img/pdf.png') }}";
                            } else if (file.file_mime_type.match('video.*')) {
                                image =
                                    "{{ asset('dist/img/video.png') }}";
                            } else if (['application/vnd.ms-powerpoint',
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                                ].includes(file.file_mime_type)) {
                                image =
                                    "{{ asset('dist/img/ppt.png') }}";
                            } else if (['application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                ].includes(file.file_mime_type)) {
                                image =
                                    "{{ asset('dist/img/doc.png') }}";
                            }

                            var html =
                                `<div class='upload__img-box'>
                                    <div style='background-image: url(${image})' 
                                        data-toggle='tooltip' data-placement='top' 
                                        title='${file.original_name}' class='img-bg'>
                                    </div>
                                </div>`;
                            img_wrap.append(html);
                        }
                        let validation = $(target).attr('data-validations');
                        if (validation) {
                            validation = JSON.parse(validation);
                            $(`#${input_id}`).rules("add", validation);
                        }
                    });
                    ImgUpload();

                    function ImgUpload() {
                        var imgWrap = "";
                        var imgArray = [];
                        $(document).on('change', 'input[type="file"]', function(e) {

                            let check_id = $(this).attr('data-id');
                            if (check_id) {
                                let configuration = confirm(
                                    'Really want to replace the current file?');
                                if (!configuration) {
                                    var fileBuffer = new DataTransfer();
                                    document.getElementById($(this).attr('id')).files = fileBuffer
                                        .files;
                                    return;
                                } else {
                                    AddRemoveReplacedMediaId(check_id);
                                }
                            }
                            let img_wrap = $(this).closest('.upload-row');
                            var files = e.target.files;
                            var filesArr = Array.prototype.slice.call(files);

                            filesArr.forEach(function(file, index) {

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    let image = '';
                                    if (file.type.match('image.*')) {
                                        image = e.target.result;
                                    } else if (file.type.match('application/pdf')) {
                                        image =
                                            "{{ asset('dist/img/pdf.png') }}";
                                    } else if (file.type.match('video.*')) {
                                        image =
                                            "{{ asset('dist/img/video.png') }}";
                                    } else if (['application/vnd.ms-powerpoint',
                                            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                                        ].includes(file.type)) {
                                        image =
                                            "{{ asset('dist/img/ppt.png') }}";
                                    } else if (['application/msword',
                                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                        ].includes(file.type)) {
                                        image =
                                            "{{ asset('dist/img/doc.png') }}";
                                    }
                                    var html =
                                        `<div class="upload__img-wrap">
                                            <div class='upload__img-box'>
                                                <div style='background-image: url(${image})' 
                                                    data-toggle='tooltip' data-placement='top' 
                                                    title='${file.name}' class='img-bg'>
                                                </div>
                                            </div>
                                        </div>`;
                                    html = html +
                                        '<button type="button" class="btn btn-danger remove_upload_row"><i class="fas fa-times"></i></button>';
                                    // console.log(html);
                                    // console.log($(this).attr("id"));
                                    img_wrap.find(
                                        '.upload__img-wrap, .remove_upload_row, .delete_upload_row'
                                    ).remove();
                                    img_wrap.append(html);

                                }
                                reader.readAsDataURL(file);

                            });
                            // let validation = $(target).attr('data-validations');
                            // if (validation) {
                            //     validation = JSON.parse(validation);
                            //     $(`#${check_id}`).rules("add", validation);
                            // }

                        });

                        // console.log(validator.settings.rules);
                        // updateTopicCount();
                    }
                    reinitCKIntances()

                    // console.log(validator.form());
                });

                /*
                 * This function sets the name updates the id of topic input and textarea.
                 */
                function updateTopicCount(is_validate = true) {
                    // Check the number of topics exists in document
                    let topic_count = $(".topic_html").length;

                    // Loop the topics
                    for (let index = 0; index < topic_count; index++) {
                        // Get all input and textarea to be renamed and set id
                        let input_element = $($(".topic_html")[index]).find('input,textarea');

                        // Get data-name of every element
                        let input_element_names = input_element
                            .map((index, ele) => {
                                return {
                                    'data_name': ele.getAttribute('data-name'),
                                    'type': ele.type,
                                }
                            });

                        // Group the elements to know if element has multiple attribute
                        let group_names = Object.groupBy(input_element_names, ({
                            data_name
                        }) => data_name);

                        // Loop the grouped names
                        for (const key in group_names) {
                            if (Object.hasOwnProperty.call(group_names, key)) {
                                const element = group_names[key];

                                // Loop the element
                                element.forEach((e, i) => {
                                    let t = e.type == 'textarea' ? 'textarea' : 'input';

                                    // create the name of element
                                    let input_name = `topic[${index}][${e.data_name}]` + (e.type ==
                                        'file' ?
                                        '[]' : '');

                                    // create the id of element
                                    let input_id =
                                        (e.type == 'file') ? `topic_${index}_${i}_${e.data_name}` :
                                        `topic_${index}_${e.data_name}`;

                                    // Find the element in DOM
                                    let find_element = $(
                                        `#topics_container div.topic_html:eq(${index}) ${t}[data-name=${e.data_name}]:eq(${i})`
                                    );

                                    // Make name attribute of element
                                    find_element.attr('name', input_name);
                                    // Make id attribute of element
                                    find_element.attr('id', input_id);

                                    // Get the validation JSON from element
                                    let validation = $(find_element).attr('data-validations');

                                    // If validation found
                                    if (validation != undefined) {
                                        // Convert the string into JSON
                                        validation = JSON.parse(validation);
                                        // if (e.type === 'textarea') {
                                        //     validation.required =
                                        //         function() {
                                        //             `CKEDITOR.instances.${input_id}.updateElement()`;
                                        //         };
                                        //     console.log('validation', validation);
                                        // }
                                        // Add rule into jquery validator
                                        $(`#${input_id}`).rules("add", validation);
                                    }
                                });
                            }
                        }
                    }
                    console.log(validator);
                }

                $(document).on("click", "#add_topic", function() {
                    // $("#quickForm").validate();
                    if (validator.form()) {
                        $("#topics_container").append(`<?php echo $action; ?>`);
                        updateTopicCount();
                        reinitCKIntances();
                    }
                });

                $(document).on("click", ".remove_html", function() {
                    updateTopicCount();

                    /*
                     * Remove rules from the jquery validator for the topic going to be removed from DOM
                     * code start 
                     */
                    let input_element = $(this).closest('.topic_html').find('input,textarea');
                    for (const key in input_element) {
                        if (Object.hasOwnProperty.call(input_element, key)) {
                            const element = input_element[key];
                            if ($(element).attr('id') != undefined) {
                                $(`#${$(element).attr('id')}`).rules("remove");
                            }
                        }
                    }
                    $(this).closest('.topic_html').remove();
                });

                function disableEnableAddFileButton(element) {
                    let button = $(element).closest('.upload-file').find('.add-file');
                    // console.log(button);
                    // console.log($(element).closest('.upload-file').find('.upload-row').length);
                    if ($(element).closest('.upload-file').find('.upload-row').length == 2) {
                        button.prop('disabled', true);
                    } else {
                        button.prop('disabled', false);
                    }
                }

                $(document).on("click", ".add-file", function() {
                    let html = $(this).closest(".upload-file")
                        .find('div.upload-row:eq(0) input[type=file]').clone();
                    html.removeAttr('data-files data-id name');
                    var el = html[0];
                    let upload_row =
                        `<div class="upload-row mp-1">
                            ${el.outerHTML}
                            <button type="button" class="btn btn-danger remove_upload_row">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`
                    $(this).closest(".upload-file").find('.form-group').append(upload_row);
                    updateTopicCount();
                    disableEnableAddFileButton($(this));
                });

                $(document).on("click", ".remove_upload_row", function() {
                    let input_file = $(this).siblings('input[type=file]');
                    // Check if file is already uploaded
                    if (id = input_file.attr('data-id')) {
                        AddRemoveReplacedMediaId(id);
                        let file_data = JSON.parse(input_file.attr('data-files'));
                        let delete_url = `${window.location.origin}/ajax/media/${id}/delete`;
                        var fileBuffer = new DataTransfer();
                        document.getElementById(input_file.attr('id')).files = fileBuffer.files;
                        let image_div = $(this).siblings('.upload__img-wrap').find(
                            '.upload__img-box .img-bg')
                        image_div.attr('title', file_data.original_name);
                        if (file_data.file_mime_type.match('image.*')) {
                            // background-image: url(${image})
                            let image_path = `${window.location.origin}/storage/${file_data.file_path.replace(
                                        /\\/g, "/")}`;
                            image_div.css("background-image", `url(${image_path})`);
                        }
                        $(this).removeClass('remove_upload_row').addClass('delete_upload_row').attr(
                            'data-route', delete_url);
                        $(this).find('i').removeClass('fa-times').addClass('fa-trash')
                        $(this).closest('.upload-file').find('.error').remove();
                    } else {
                        let that = $(this).closest('.form-group');
                        let first_input_field = $(this).closest('.form-group').find(
                            'div.upload-row:eq(0) input[type=file]');
                        // console.log(countUploadRows(first_input_field));
                        let id = $(this).closest('.form-group').find(
                                'div.upload-row:eq(0) input[type=file]')
                            .attr('id');
                        // console.log(id);
                        updateTopicCount();
                        let element = $(this);

                        // Check if this is last upload_row
                        let upload_row_html = '';
                        if (that.find('.upload-row').length == 1) {
                            let input_file = that.find('.upload-row input[type=file]')
                                .removeAttr('data-files');
                            let html = document.getElementById($(input_file[0]).attr(
                                'id')).outerHTML;
                            upload_row_html =
                                `<div class="upload-row mp-1">${html}</div>`;
                        }

                        $(this).closest('.upload-row').remove();
                        // $("#quickForm").data('validator').element('#' + id);
                        if (countUploadRows(first_input_field)) {
                            $(first_input_field).closest('.upload-file').find('label.error').remove();
                        }
                        disableEnableAddFileButton($(that));

                        if (upload_row_html != '') {
                            that.prepend(upload_row_html);
                        }
                        $(that).closest('.upload-file').find('.error').remove();
                    }
                });

                $(document).on("click", ".delete_upload_row", function() {
                    let that = $(this).closest('.form-group');
                    const route = $(this).attr('data-route');
                    const image_box = $(this).closest('.upload-row');

                    var confirmation = confirm('Really want to delete this media?');
                    if (confirmation) {
                        $.ajax({
                            type: "POST",
                            url: route,
                            dataType: "json",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(data) {
                                if (data.status == true) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });

                                    // Check if this is last upload_row
                                    let upload_row_html = '';
                                    if (that.find('.upload-row').length == 1) {
                                        let input_file = that.find(
                                                '.upload-row input[type=file]')
                                            .removeAttr('data-files');
                                        let html = document.getElementById($(input_file[0])
                                            .attr(
                                                'id')).outerHTML;
                                        upload_row_html =
                                            `<div class="upload-row mp-1">${html}</div>`;
                                    }
                                    image_box.remove();
                                    disableEnableAddFileButton(that);

                                    if (upload_row_html != '') {
                                        that.prepend(upload_row_html);
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                });

                $(document).on("click", ".delete_topic", function() {
                    console.log('here');
                    let that = $(this);
                    let confirmation = confirm('Do you really want to delete this topic?');
                    const route = $(this).attr('data-route');
                    if (confirmation) {
                        $.ajax({
                            url: route,
                            method: 'DELETE',
                            // dataType: "json",
                            // cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(data) {
                                if (data.status == true) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });
                                    that.closest('.topic_html').remove();
                                    updateTopicCount();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                });

                $(document).on("click", ".add-remark", function(e) {
                    e.preventDefault();
                    console.log("here");
                });
            });
        </script>
    @endpush
</x-admin-layout>

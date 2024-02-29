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
                width: 50px;
                padding: 0 10px;
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
                border: 1px solid #ced4da;
                margin-bottom: 10px;
                padding: 10px 10px;
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    @php
        // $action = view('components.admin.course.topic', [
        //     'configuration' => $configuration,
        //     'topic' => null,
        //     'loop' => null,
        // ])->render();
    @endphp
    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Edit Course') }}
            </x-slot>
            <div class="card-body p-0">
                <form method="POST"
                    action="{{ route('manage.courses.edit', ['course' => encrypt($course->id), 'fk_course_category_courses_id' => encrypt($course->assignedAdmin->fk_course_category_courses_id)]) }}"
                    enctype="multipart/form-data" id="quickForm">
                    @csrf
                    <div style="padding: 1.25rem;">
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
                                    <x-label for="description">Course Description <span
                                            class="text-danger">*</span></x-label>
                                    <textarea type="text" name="description" class="form-control editor" id="course_description"
                                        placeholder="Enter Course Description">{{ old('description', $course->update_description ? $course->update_description : $course->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 upload-file">
                                <div class="d-flex">
                                    <div class="col-md-12 upload-file">
                                        <label>Course Thumbnail</label>
                                        <div class="form-group">
                                            @if ($course->upload)
                                                <div class="upload-row mp-1 flex-wrap">
                                                    <input type="file" name="course_thumbnail"
                                                        class="course_thumbnail" id="course_thumbnail"
                                                        data-files="{{ $course->upload }}"
                                                        data-id="{{ encrypt($course->upload->id) }}"
                                                        accept="image/png, image/jpeg" />
                                                    <div class="upload__img-wrap"></div>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete_upload_row"
                                                        data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course->upload->id)]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="upload-row mp-1 flex-wrap">
                                                    <input type="file" name="course_thumbnail"
                                                        class="course_thumbnail" id="course_thumbnail"
                                                        accept="image/png, image/jpeg" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="topics_container">
                            @if ($course->topics->count())
                                @foreach ($course->topics as $topic)
                                    <x-admin.course.topic :configuration="$configuration" :topic="$topic" :loop="$loop" />
                                    {{-- @php
                                    $html = view('components.admin.course.topic', [
                                        'configuration' => $configuration ?? null,
                                        'topic' => $topic,
                                        'loop' => $loop,
                                    ])->render();
                                    echo $html;
                                @endphp --}}
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
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <x-admin.captcha />
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-md-6 mb-2 mt-2">

                                <button type="submit" class="btn btn-success" name="action" value="request">Request to
                                    Approve</button>
                                <button type="submit" class="btn btn-primary" name="action" value="draft">Save as
                                    Draft</button>
                                @if ($course->requests->count())
                                    <button type="button" class="btn btn-secondary"
                                        id="show-remark-modal">Action</button>
                                @endif
                            </div>
                            <div class="col-md-6 mb-2 mt-2" style="text-align: right">
                                <button type="button" class="btn btn-secondary" id="add_topic"><i
                                        class="fas fa-plus"></i>
                                    Add More Topics</button>
                            </div>
                        </div>
                    </div>
                </form>
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
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
        </script>
        <script type="text/javascript"
            src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
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
                    height: "60px",
                });
            }

            function reinitCKIntances() {
                $("textarea.editor").each((e, a) => {
                    var instance = CKEDITOR.instances[a.id];
                    if (instance) {
                        CKEDITOR.remove(instance);
                        instance.destroy(true);
                        instance = null;
                    }
                    initCK(a.id);
                });
            }

            // function loadEditors() {
            //     var $editors = $("textarea.ckeditor");
            //     if ($editors.length) {
            //         $editors.each(function() {
            //             var editorID = $(this).attr("id");
            //             var instance = CKEDITOR.instances[editorID];
            //             if (instance) {
            //                 console.log('destroy');
            //                 instance.destroy(true);
            //             }

            //         });
            //     }
            // }

            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });

                // Data table for requests and remarks
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

                // Opens Remark Modal
                $("#show-remark-modal").on("click", function() {
                    $("#remark-modal").modal("show");
                    $("#remark").closest('.row').hide();
                    $("#remark").val('');
                    table.ajax.reload();
                });

                // Show remark on textarea element
                $(document).on("click", ".view-remark", function() {
                    $("#remark").closest('.row').show();
                    $("#remark").val($(this).attr('data-remark'));
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

                function GetTextFromHtml(html) {
                    var dv = document.createElement("DIV");
                    dv.innerHTML = html;
                    return dv.textContent || dv.innerText || "";
                }
                jQuery.validator.addMethod("ckrequired", function(value, element) {
                    var idname = $(element).attr('id');
                    var editor = CKEDITOR.instances[idname];
                    var ckValue = GetTextFromHtml(editor.getData()).replace(/<[^>]*>/gi, '').trim();
                    if (ckValue.length === 0) {
                        //if empty or trimmed value then remove extra spacing to current control
                        $(element).val(ckValue);
                    } else {
                        //If not empty then leave the value as it is
                        $(element).val(editor.getData());
                    }
                    return $(element).val().length > 0;
                }, "This field is required");

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


                var validator = jQuery("#quickForm").validate({
                    rules: {
                        description: {
                            ckrequired: true
                        },
                        // captcha: {
                        //     required: true,
                        // },
                    },
                    messages: {
                        description: {
                            ckrequired: 'Description is required.',
                            maxlength: 250
                        },
                        // captcha: {
                        //     required: 'Security Code is required.',
                        // },
                    },
                    errorPlacement: function(error, element) {
                        if (
                            element.attr("name").includes('[course_pdf][]') ||
                            element.attr("name").includes('[course_ppt][]') ||
                            element.attr("name").includes('[course_doc][]')
                        ) {
                            error.insertAfter($(element).closest('.form-group'));
                        } else if (element.prop('localName') === 'textarea') {
                            error.insertAfter($('#cke_' + element.attr('id')));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        $(document).ready(function() {
                            if ($('input[name="saved_as"]').attr('value') == 'draft') {
                                let data = $(form).serializeArray();
                                var form_data = new FormData();
                                data.forEach(d => form_data.append(d.name, d.value))

                                // Append All uploaded files into FormData
                                $('input[type="file"]').each(function(index, target) {
                                    if (target.files.length > 0) {
                                        let file = target.files;
                                        if (file[0] != undefined) {
                                            form_data.append(target.name, file[0]);
                                        }
                                    }
                                });

                                // Save all data by ajax
                                $.ajax({
                                    type: "POST",
                                    url: $(form).attr('action'),
                                    data: form_data,
                                    cache: false,
                                    dataType: 'json',
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function(data) {
                                        // Hide the server side validation errors
                                        $(".ss-validation").remove();
                                        // if (data.captcha) {
                                        //     $('input[name=captcha]').val('');
                                        //     $('.captcha-image').attr('src', data.captcha);
                                        // }
                                        if (data.status == true) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: data.message
                                            });

                                            // If any file is uploaded reload the page.
                                            // Issue is we will need to update course_video_id of each topic
                                            location.reload();
                                        } else {
                                            // Show server side validation errors
                                            $("#quickForm .card-body:first")
                                                .prepend(data.errors);

                                            // Scroll the page on top
                                            $("html, body").animate({
                                                scrollTop: 0
                                            }, 500);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            } else {
                                // Take confirmation before submit course content for approval to Nodal Officer
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

                // If any media replaced
                // Store the id of media into input filed comma saperated
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


                // Create image preview
                function imagePreview(image, name) {
                    return `<div class='upload__img-box'>
                                    <div style='background-image: url(${image})'
                                        data-toggle='tooltip' data-placement='top'
                                        title='${name}' class='img-bg'>
                                    </div>
                                </div>`;
                }

                // Return image path fetch from DB Object or recent Uploaded file
                function getImageByMimeType(file, e) {
                    let image = '';
                    let mime_type = file.hasOwnProperty('file_mime_type') ? file.file_mime_type : file.type;
                    let asset = '{{ asset('') }}';
                    if (mime_type.match('image.*')) {
                        if (file.hasOwnProperty('file_mime_type')) {
                            image = asset + 'storage/' + file
                                .file_path.replace(
                                    /\\/g, "/");
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
                    return image;
                }

                // Add validation into validator
                function addValidation(target) {
                    let input_id = $(target).attr('id');

                    // Get the validation JSON from element
                    let validation = $(target).attr('data-validations');

                    // If validation found
                    if (validation != undefined) {
                        // Convert the string into JSON
                        validation = JSON.parse(validation);
                        // Add rule into jquery validator
                        $(`#${input_id}`).rules("add", validation);
                    }
                }

                function parseFileData(target) {
                    let data_files = target.getAttribute('data-files');
                    return (data_files) ? JSON.parse(data_files) : null;
                }

                $(document).ready(function() {
                    setTopicFieldsName();

                    ImgUpload();

                    function ImgUpload() {
                        var imgWrap = "";
                        var imgArray = [];

                        // Read all input type=file and
                        // Fetch image data to create image preview
                        $('input[type="file"]').each(function(index, target) {
                            let file = parseFileData(target);
                            let img_wrap = $(target).siblings('.upload__img-wrap');
                            if (file) {
                                let image = getImageByMimeType(file, target);
                                var html = imagePreview(image, file.original_name);

                                img_wrap.append(html);
                            }
                        });

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
                                    let image = getImageByMimeType(file, e);
                                    var html = imagePreview(image, file.name);
                                    html = html +
                                        '<button type="button" class="btn btn-danger btn-sm remove_upload_row"><i class="fas fa-times"></i></button>';
                                    img_wrap.find(
                                        '.upload__img-wrap, .remove_upload_row, .delete_upload_row'
                                    ).remove();
                                    img_wrap.append(html);
                                }
                                reader.readAsDataURL(file);
                            });
                        });
                    }
                    reinitCKIntances()
                });

                /*
                 * This function sets the name updates the id of topic input and textarea.
                 */
                function setTopicFieldsName(is_validate = true) {
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

                                    addValidation(find_element);
                                });
                            }
                        }
                    }
                    // console.log(validator.settings.rules);
                }

                // Add new topic html into form
                $(document).on("click", "#add_topic", function() {
                    // $("#quickForm").validate();
                    if (validator.form()) {
                        $("#topics_container").append(`<?php echo $action; ?>`);
                        setTopicFieldsName();
                        reinitCKIntances();
                    }
                });

                // Remove the topic from form
                $(document).on("click", ".remove_topic", function() {
                    setTopicFieldsName();

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
                    button.prop('disabled', ($(element).closest('.upload-file').find('.upload-row').length == 2));
                }

                // Check if this is last upload_row
                function checkHasLastUploadHtml(element) {
                    let upload_row_html = '';
                    if (element.find('.upload-row').length == 1) {
                        let input_file = element.find(
                                '.upload-row input[type=file]')
                            .removeAttr('data-files');
                        let html = document.getElementById($(input_file[0])
                            .attr(
                                'id')).outerHTML;
                        upload_row_html = createUploadRow(html);
                    }
                    return upload_row_html;
                }

                function createUploadRow(html, button = null) {
                    let button_html = '';
                    if (button) {
                        if (button == 'remove') {
                            button_html = `<button type="button" class="btn btn-danger btn-sm remove_upload_row">
                                <i class="fas fa-times"></i>
                            </button>`;
                        }
                    }
                    return `<div class="upload-row mp-1 flex-wrap">
                            ${html}${button_html}
                        </div>`;
                }

                // Add new input element to upload file
                $(document).on("click", ".add-file", function() {
                    let html = $(this).closest(".upload-file")
                        .find('div.upload-row:eq(0) input[type=file]').clone();
                    if (validator.element(`#${html[0].id}`) === false) {
                        return;
                    }
                    html.removeAttr('data-files data-id name');
                    var el = html[0];
                    let upload_row = createUploadRow(el.outerHTML, 'remove');
                    $(this).closest(".upload-file").find('.form-group').append(upload_row);
                    setTopicFieldsName();
                    disableEnableAddFileButton($(this));
                });

                // Remove upload file row
                $(document).on("click", ".remove_upload_row", function(e) {
                    let input_file = $(this).siblings('input[type=file]');

                    // Check if file is already uploaded
                    if (id = input_file.attr('data-id')) {
                        AddRemoveReplacedMediaId(id);
                        let file_data = JSON.parse(input_file.attr('data-files'));
                        let delete_url = `${window.location.origin}/ajax/media/${id}/delete`;
                        var fileBuffer = new DataTransfer();
                        document.getElementById(input_file.attr('id')).files = fileBuffer.files;
                        let image_div = $(this).siblings('.upload__img-wrap')
                            .find('.upload__img-box .img-bg')
                        image_div.attr('title', file_data.original_name);

                        let image_path = getImageByMimeType(file_data, e);
                        // if (file_data.file_mime_type.match('image.*')) {
                        if (image_path) {
                            // let image_path = `${window.location.origin}/storage/${file_data.file_path.replace(/\\/g, "/")}`;
                            image_div.css("background-image", `url(${image_path})`);
                        }
                        $(this).removeClass('remove_upload_row')
                            .addClass('delete_upload_row')
                            .attr('data-route', delete_url);

                        $(this).find('i')
                            .removeClass('fa-times')
                            .addClass('fa-trash')

                        $(this).closest('.upload-file')
                            .find('.error')
                            .remove();
                    } else {
                        let that = $(this).closest('.form-group');
                        let first_input_field = $(this).closest('.form-group').find(
                            'div.upload-row:eq(0) input[type=file]');

                        let id = $(this).closest('.form-group')
                            .find('div.upload-row:eq(0) input[type=file]')
                            .attr('id');

                        setTopicFieldsName();
                        let element = $(this);

                        // Check if this is last upload_row
                        let upload_row_html = checkHasLastUploadHtml(that)

                        element.closest('.upload-row').remove();
                        // $("#quickForm").data('validator').element('#' + id);
                        if (countUploadRows(first_input_field)) {
                            $(first_input_field).closest('.upload-file').find('label.error').remove();
                        }
                        disableEnableAddFileButton($(that));
                        if (upload_row_html != '') {
                            that.prepend(upload_row_html);
                        }
                        $(that).closest('.upload-file')
                            .find('label.error')
                            .remove();
                    }
                });

                // Delete Uploaded file by ajax
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
                                    let upload_row_html = checkHasLastUploadHtml(that);
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

                // Delete Whole topic by ajax
                $(document).on("click", ".delete_topic", function() {
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
                                    setTopicFieldsName();
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
                });
            });
        </script>
    @endpush
</x-admin-layout>

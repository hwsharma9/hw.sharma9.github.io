<x-admin-layout>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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

            .upload__img-close {
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
                content: '\2716';
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

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
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

    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('ADD Course') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.courses.create', ['fk_course_category_courses_id' => encrypt($alloted_admin->fk_course_category_courses_id)]) }}"
                id="quickForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label>Category</x-label>
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
                            <textarea type="text" name="description" class="form-control" id="description"
                                placeholder="Enter Course Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 upload-file">
                        <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                            <legend>Course Thumbnail</legend>
                            <div class="form-group">
                                <div class="upload-row mp-1">
                                    <input type="file" name="course_thumbnail" class="course_thumbnail"
                                        id="course_thumbnail" accept="image/png, image/jpeg" />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row" id="topics_container"></div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer">
                    {{-- <x-admin.form-actions :actions="[
                        'create' => true,
                    ]" /> --}}
                    <button type="submit" class="btn btn-primary" name="action" value="draft">Save as
                        Draft</button>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @php
        $action = view('components.admin.course.topic', [
            'configuration' => $configuration ?? null,
            'topic' => null,
            'loop' => null,
        ])->render();
    @endphp
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {

                function countUploadRows(element) {
                    let file_box = $(element).closest('.form-group').find('.upload-row');
                    return !(file_box.length > 2);
                }

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        description: {
                            required: function(e) {
                                console.log(e.target);
                                return true;
                            },
                        },
                        captcha: {
                            required: false,
                        },
                    },
                    messages: {
                        description: {
                            required: 'Description is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });

                function reinitCKIntances() {
                    $("textarea").each((e, a) => {
                        var instance = CKEDITOR.instances[a.id];
                        if (instance) {
                            CKEDITOR.remove(instance);
                            instance.destroy(true);
                            instance = null;
                        }
                        initCK(a.id);
                    });
                }
                reinitCKIntances();

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

                jQuery(document).ready(function() {
                    ImgUpload();
                });

                function ImgUpload() {
                    var imgWrap = "";
                    var imgArray = [];

                    $(document).on('change', 'input[type="file"]', function(e) {
                        let img_wrap = $(this).closest('.upload-row');
                        var maxLength = $(this).attr('data-max_length');

                        var files = e.target.files;
                        var filesArr = Array.prototype.slice.call(files);
                        var iterator = 0;
                        let mime_type = $(this).attr('accept').replace(/\s/g, '').split(',');
                        filesArr.forEach(function(f, index) {
                            if (!mime_type.includes(f.type)) return;

                            if (imgArray.length > maxLength) {
                                return false
                            } else {
                                var len = 0;
                                for (var i = 0; i < imgArray.length; i++) {
                                    if (imgArray[i] !== undefined) {
                                        len++;
                                    }
                                }
                                if (len > maxLength) {
                                    return false;
                                } else {
                                    imgArray.push(f);

                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        let image = '';
                                        if (f.type.match('image.*')) {
                                            image = e.target.result;
                                        } else if (f.type.match('application/pdf')) {
                                            image =
                                                "{{ asset('dist/img/pdf.png') }}";
                                        } else if (f.type.match('video.*')) {
                                            image =
                                                "{{ asset('dist/img/video.png') }}";
                                        } else if (['application/vnd.ms-powerpoint',
                                                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                                            ].includes(f.type)) {
                                            image =
                                                "{{ asset('dist/img/ppt.png') }}";
                                        } else if (['application/msword',
                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                            ].includes(f.type)) {
                                            image =
                                                "{{ asset('dist/img/doc.png') }}";
                                        }
                                        var html =
                                            `<div class="upload__img-wrap">
                                            <div class='upload__img-box'>
                                                <div style='background-image: url(${image})' 
                                                    data-toggle='tooltip' data-placement='top' 
                                                    title='${f.name}' class='img-bg'>
                                                </div>
                                            </div>
                                        </div>`;
                                        html = html +
                                            '<button type="button" class="btn btn-danger remove_upload_row"><i class="fas fa-times"></i></button>';

                                        img_wrap.append(html);
                                        iterator++;
                                    }
                                    reader.readAsDataURL(f);
                                }
                            }
                        });
                    });
                }

                $(document).on("click", ".remove_upload_row", function() {
                    let input_file = $(this).siblings('input[type=file]');

                    let that = $(this).closest('.form-group');
                    let first_input_field = $(this).closest('.form-group').find(
                        'div.upload-row:eq(0) input[type=file]');

                    let id = $(this).closest('.form-group').find('div.upload-row:eq(0) input[type=file]')
                        .attr('id');

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
                    if (countUploadRows(first_input_field)) {
                        $(first_input_field).closest('.upload-file').find('label.error').remove();
                    }

                    if (upload_row_html != '') {
                        that.prepend(upload_row_html);
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>

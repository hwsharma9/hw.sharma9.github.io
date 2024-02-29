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
                width: 50px;
                padding: 0 10px;
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

            .media-container {
                border: 1px solid #ced4da;
                margin-bottom: 10px;
            }

            .media-container .upload-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 10px;
            }

            .media-container .media-error {
                margin-left: 10px;
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
                <div class="card-body">
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
                                <x-label for="description">Course Description <span
                                        class="text-danger">*</span></x-label>
                                <textarea type="text" name="description" class="form-control" id="description"
                                    placeholder="Enter Course Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 upload-file">
                            <div class="col-md-12 upload-file">
                                <x-label>Course Thumbnail</x-label>
                                <div class="form-group">
                                    <div class="media-container mp-1">
                                        <div class="upload-row flex-wrap">
                                            <input type="file" name="course_thumbnail" class="course_thumbnail"
                                                id="course_thumbnail" accept="image/png, image/jpeg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="action" value="draft">Save as
                        Draft</button>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {

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

                function countUploadRows(element) {
                    let file_box = $(element).closest('.form-group').find('.upload-row');
                    return !(file_box.length > 2);
                }

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        description: {
                            ckrequired: true,
                        },
                        captcha: {
                            required: true,
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
                        height: "60px",
                    });
                }

                jQuery(document).ready(function() {
                    ImgUpload();
                });

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


                // Create image preview
                function imagePreview(image, name) {
                    return `<div class='upload__img-box'>
                        <div style='background-image: url(${image})'
                            data-toggle='tooltip' data-placement='top'
                            title='${name}' class='img-bg'>
                        </div>
                    </div>`;
                }

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
                                        let image = getImageByMimeType(f, e);

                                        var html = imagePreview(image, f.name);
                                        html = `<div class="upload__img-wrap">${html}</div>` +
                                            '<button type="button" class="btn btn-danger btn-sm remove_upload_row"><i class="fas fa-times"></i></button>';

                                        img_wrap.append(html);
                                        iterator++;
                                    }
                                    reader.readAsDataURL(f);
                                }
                            }
                        });
                    });
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
                    return `<div class="media-container mp-1">
                        <div class="upload-row flex-wrap">
                            ${html}${button_html}
                        </div>
                    </div>`;
                }

                // Check if this is last upload_row
                function checkHasLastUploadHtml(element) {
                    let upload_row_html = '';
                    if (element.find('.upload-row').length == 1) {
                        let input_file = element.find(
                                '.upload-row input[type=file]')
                            .removeAttr('data-files')
                            .removeAttr('data-id');
                        let html = document.getElementById($(input_file[0])
                            .attr(
                                'id')).outerHTML;
                        upload_row_html = createUploadRow(html);
                    }
                    return upload_row_html;
                }

                $(document).on("click", ".remove_upload_row", function() {
                    let input_file = $(this).siblings('input[type=file]');

                    let that = $(this).closest('.form-group');
                    let first_input_field = $(this).closest('.form-group')
                        .find('div.upload-row:eq(0) input[type=file]');

                    let id = $(this).closest('.form-group')
                        .find('div.upload-row:eq(0) input[type=file]')
                        .attr('id');

                    let element = $(this);

                    // Check if this is last upload_row
                    let upload_row_html = checkHasLastUploadHtml(that);

                    $(this).closest('.media-container').remove();
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

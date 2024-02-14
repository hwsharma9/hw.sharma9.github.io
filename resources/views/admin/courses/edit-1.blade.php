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

    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Edit Course') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.courses.edit', ['course' => encrypt($course->id), 'fk_course_category_courses_id' => encrypt($course->assignedAdmin->fk_course_category_courses_id)]) }}"
                enctype="multipart/form-data" id="quickForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="fk_course_category_id">Category <span class="text-danger">*</span></x-label>
                            <input class="form-control" disabled
                                value="{{ $alloted_admin->courseCategory->category_name_en }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="fk_course_category_id">Course</x-label>
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
                                placeholder="Enter Course Description">{{ old('description', $course->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 upload-file">
                        <div class="d-flex">
                            <div class="form-group">
                                <x-label for="course_thumbnail">Course Thumbnail</x-label>
                                <input type="file" name="course_thumbnail" class="course_thumbnail"
                                    data-files={{ $course->uploads }} style="width: 100%;"
                                    accept="image/png, image/jpeg" />
                            </div>
                            <div class="upload__img-wrap"></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="topics_container">
                    @if ($course->topics)
                        @foreach ($course->topics as $topic)
                            @php
                                $html = view('components.admin.topic', [
                                    'configuration' => $configuration ?? null,
                                    'topics' => $course->topics,
                                ])->render();
                                echo $html;
                            @endphp
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.status-dropdown :selected="$course->status" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>
                        <x-admin.form-actions :actions="[
                            'update' => true,
                            'update_back' => route('manage.courses.edit', $course->id),
                            'clear' => true,
                            'back' => route('manage.courses.index'),
                        ]" />
                    </span>
                    <span>
                        <button type="button" class="btn btn-secondary" id="add_topic">Add Topic</button>
                    </span>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @php
        $action = view('components.admin.topic', [
            'configuration' => $configuration ?? null,
            'topics' => null,
        ])->render();
    @endphp
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });

                jQuery.validator.addMethod("limit_file_upload", function(value, element) {
                    let file_box = $(element).closest(".upload-file").find(
                        ".upload__img-wrap .upload__img-box");
                    return !(file_box.length > 2);
                }, "You can upload up to 2 files for each topic.");

                jQuery.validator.addMethod("validate_file_size", function(value, element) {
                    let is_fine = true;
                    let files = document.getElementById(element.id).files;
                    if (files.length) {
                        console.log(files);
                        // files.forEach(file => {
                        //     if (file.size > 2097152) {
                        //         is_fine = false;
                        //     };
                        // })
                    }
                    console.log("is_fine => ", is_fine);
                    return is_fine;
                }, "You can upload up to 2 files for each topic.");

                var validator = jQuery("#quickForm").validate({
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
                            required: 'Security Code is required.',
                        },
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });

                // function addRule(element, is_validate) {
                //     if (is_validate) {
                //         let validation = $(element).attr('data-required');
                //         if (validation) {
                //             validation = JSON.parse(validation);
                //             $(`#${input_id}`).rules("add", validation);
                //         }
                //     } else {
                //         $(`#${input_id}`).rules("remove");
                //     }
                // }

                function updateTopicCount(is_validate = true) {
                    let topic_count = $(".topic_html").length;
                    for (let index = 0; index < topic_count; index++) {
                        let input_element = $($(".topic_html")[index]).find('input,textarea');
                        for (let ie_index = 0; ie_index < input_element.length; ie_index++) {
                            let single_element = $(input_element)[ie_index];
                            let input_name = `topic[${index}][${$(single_element).attr('data-name')}]`;
                            let input_id = `topic_${index}_${$(single_element).attr('data-name')}`;
                            $(single_element).attr('name', input_name + (
                                $(single_element).attr('multiple') ? '[]' : ''));
                            $(single_element).attr('id', input_id);
                            // addRule(single_element, is_validate)
                            if (is_validate) {
                                let validation = $(single_element).attr('data-required');
                                if (validation) {
                                    validation = JSON.parse(validation);
                                    $(`#${input_id}`).rules("add", validation);
                                }
                            } else {
                                $(`#${input_id}`).rules("remove");
                            }
                        }
                    }
                    console.log(validator);
                }

                $("#add_topic").on("click", function() {
                    $("#topics_container").append(`<?php echo $action; ?>`);
                    updateTopicCount();
                });

                $(document).on("click", ".remove_html", function() {
                    updateTopicCount(false);
                    $(this).closest('.topic_html').remove();
                });

                $(function() {
                    $("#quickForm").change(function() {
                        console.log($(this).serializeArray());
                        // this.submit();
                    });
                });

                jQuery(document).ready(function() {
                    ImgUpload();
                });

                function ImgUpload() {
                    var imgWrap = "";
                    var imgArray = [];

                    $(document).on('change', 'input[type="file"]', function(e) {
                        imgWrap = $(this).closest('.upload-file').find('.upload__img-wrap');
                        var maxLength = $(this).attr('data-max_length');

                        var files = e.target.files;
                        var filesArr = Array.prototype.slice.call(files);
                        var iterator = 0;
                        let mime_type = $(this).attr('accept').replace(/\s/g, '').split(',');
                        filesArr.forEach(function(f, index) {
                            // if (!mime_type.includes(f.type)) return;

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
                                            "<div class='upload__img-box'><div style='background-image: url(" +
                                            image +
                                            ")' data-toggle='tooltip' data-placement='top' title='" +
                                            f.name + "' data-number='" +
                                            $(
                                                ".upload__img-close").length +
                                            "' data-file='" + f.name +
                                            "' class='img-bg'><div class='upload__img-close'><i class='fas fa-times'></i></div></div></div>";
                                        imgWrap.append(html);
                                        iterator++;
                                    }
                                    reader.readAsDataURL(f);

                                    // Assign buffer to file input
                                }
                            }
                        });
                        addFile(imgArray, this);
                        // $("#quickForm").data('validator').element('#' + $(this).attr('id'));
                    });

                    function addFile(imgArray, that) {
                        let mime_type = $(that).attr('accept').replace(/\s/g, '').split(',');
                        var fileBuffer = new DataTransfer();

                        // append the file list to an array iteratively
                        for (let i = 0; i < imgArray.length; i++) {
                            // if (mime_type.includes(imgArray[i].type)) {
                            // Exclude file in specified index
                            fileBuffer.items.add(imgArray[i]);
                            // }
                        }
                        document.getElementsByName($(that).attr('name'))[0].files = fileBuffer.files;
                    }

                    function removeFile(index, that) {
                        var attachments = document.getElementsByName($(that).attr('name'))[0]
                            .files; // <-- reference your file input here
                        var fileBuffer = new DataTransfer();

                        // append the file list to an array iteratively
                        for (let i = 0; i < attachments.length; i++) {
                            // Exclude file in specified index
                            if (index !== i) {
                                fileBuffer.items.add(attachments[i]);
                            }
                        }

                        // Assign buffer to file input
                        document.getElementsByName($(that).attr('name'))[0].files = fileBuffer
                            .files; // <-- according to your file input reference
                    }

                    $('body').on('click', ".upload__img-close", function(e) {
                        var file = $(this).parent().data("file");
                        let input_file = $(this).closest('.upload-file').find('input[type="file"]')
                        for (var i = 0; i < imgArray.length; i++) {
                            if (imgArray[i].name === file) {
                                removeFile(i, input_file);
                                imgArray.splice(i, 1);
                                break;
                            }
                        }
                        $(this).closest(".upload__img-box").remove();
                        $("#quickForm").data('validator').element('#' + $(input_file).attr('id'));
                    });
                }
                $(document).ready(function() {
                    $('input[type="file"]').each(function(e) {
                        let target = $(this)[0];
                        let input_id = $(target).attr('id');
                        let imgWrap = $(target).closest('.upload-file').find('.upload__img-wrap');
                        console.log(input_id);
                        let files = JSON.parse($(target).attr('data-files'));
                        // console.log(files);
                        if (files.length) {
                            files.forEach(file => {
                                console.log(file);
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
                                // console.log(image);
                                var html =
                                    `<div class='upload__img-box'>
                                        <div style='background-image: url(${image})' 
                                            data-toggle='tooltip' data-placement='top' 
                                            title='${file.original_name}' class='img-bg'>
                                            <div class='upload__img-trash' data-route='${'ajax/media/'+file.id+'/delete'}'>
                                                <i class='fas fa-trash'></i>
                                            </div>
                                        </div>
                                    </div>`;
                                imgWrap.append(html);
                                let validation = $(target).attr('data-required');
                                if (validation) {
                                    validation = JSON.parse(validation);
                                    $(`#${input_id}`).rules("add", validation);
                                }
                            });
                        }
                        // console.log($(this).attr('data-files'));
                    });
                    console.log(validator.settings.rules);
                    $(document).on("click", ".upload__img-trash", function() {
                        const route = $(this).attr('data-route');
                        const image_box = $(this).closest('.upload__img-box');
                        var confirmation = confirm('Really want to delete this media?');
                        if (confirmation) {
                            $.ajax({
                                type: "POST",
                                url: window.location.origin + '/' + route,
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
                                        image_box.remove();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        }
                    });
                });
                // let uploaded_files = JSON.parse('<?php echo mysql_escape_mimic($medias); ?>');
                // console.log(uploaded_files);
                // createPreview(uploaded_files);
            });
        </script>
    @endpush
</x-admin-layout>

<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/bootstrap-datepicker/css/datepicker.css') }}">
    @endpush
    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course Configuration') }}</li>
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
                {{ __('ADD Course Configuration') }}
            </x-slot>
            {{-- <pre>
            @php
                print_r(old());
            @endphp
            </pre> --}}

            <form method="POST" action="{{ route('manage.course_configurations.create') }}" id="quickForm"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="course_category_id">Course Category <span
                                        class="text-danger">*</span></x-label>
                                <select name="course_category_id" id="course_category_id" class="form-control"
                                    style="width: 100%;">
                                    <option value="">Select Course Category</option>
                                    @if ($course_categories)
                                        @foreach ($course_categories as $course_category)
                                            <option value="{{ $course_category->id }}"
                                                {{ old('course_category_id') == $course_category->id ? 'selected' : '' }}>
                                                {{ $course_category->category_name_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="course_category_courses_id">Course <span
                                        class="text-danger">*</span></x-label>
                                <select name="course_category_courses_id" id="course_category_courses_id"
                                    class="form-control" style="width: 100%;">
                                    <option value="">Select Course</option>
                                    @if (old('course_category_id') && $course_categories)
                                        @php
                                            $cc = $course_categories->where('id', old('course_category_id'))->first();
                                        @endphp
                                        @if ($cc)
                                            @foreach ($cc->courses as $course_category)
                                                <option value="{{ $course_category->id }}"
                                                    {{ old('course_category_courses_id') == $course_category->id ? 'selected' : '' }}>
                                                    {{ $course_category->course_name_en }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label>Please select the course contents as madatory fields</x-label>
                                <div class="form-control" style="height: 110px;">
                                    <div class="d-flex flex-column justify-content-around">
                                        <span>
                                            <span class="w-25">
                                                <input type="checkbox" class="is_upload" name="is_upload_pdf"
                                                    {{ old('is_upload_pdf') && old('is_upload_pdf') == 'on' ? 'checked' : '' }} />
                                                Upload content in pdf file
                                            </span>
                                            <span style="display:none">
                                                <input type="checkbox" name="is_upload_pdf_required"
                                                    {{ old('is_upload_pdf_required') && old('is_upload_pdf_required') == 'on' ? 'checked' : '' }} />
                                                Is Mandatory
                                            </span>
                                        </span>
                                        <span>
                                            <span class="w-25">
                                                <input type="checkbox" class="is_upload" name="is_upload_video"
                                                    {{ old('is_upload_video') && old('is_upload_video') == 'on' ? 'checked' : '' }} />
                                                Upload video content
                                            </span>
                                            <span style="display:none">
                                                <input type="checkbox" name="is_upload_video_required"
                                                    {{ old('is_upload_video_required') && old('is_upload_video_required') == 'on' ? 'checked' : '' }} />
                                                Is Mandatory
                                            </span>
                                        </span>
                                        <span>
                                            <span class="w-25">
                                                <input type="checkbox" class="is_upload" name="is_upload_ppt"
                                                    {{ old('is_upload_ppt') && old('is_upload_ppt') == 'on' ? 'checked' : '' }} />
                                                Upload ppt contents
                                            </span>
                                            <span style="display:none">
                                                <input type="checkbox" name="is_upload_ppt_required"
                                                    {{ old('is_upload_ppt_required') && old('is_upload_ppt_required') == 'on' ? 'checked' : '' }} />
                                                Is Mandatory
                                            </span>
                                        </span>
                                        <span>
                                            <span class="w-25">
                                                <input type="checkbox" class="is_upload" name="is_upload_doc"
                                                    {{ old('is_upload_doc') && old('is_upload_doc') == 'on' ? 'checked' : '' }} />
                                                Upload contents in doc file
                                            </span>
                                            <span style="display:none">
                                                <input type="checkbox" name="is_upload_doc_required"
                                                    {{ old('is_upload_doc_required') && old('is_upload_doc_required') == 'on' ? 'checked' : '' }} />
                                                Mandatory
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="is_visible">Course Visibility</x-label>
                                <div class="form-control">
                                    <div class="d-flex justify-content-around">
                                        <span>
                                            <input type="radio" name="is_visible"
                                                {{ old('is_visible') && old('is_visible') == 1 ? 'checked' : '' }}
                                                value="1" @if (!old('is_visible')) checked @endif />
                                            Yes
                                        </span>
                                        <span>
                                            <input type="radio" name="is_visible"
                                                {{ old('is_visible') && old('is_visible') == 0 ? 'checked' : '' }}
                                                value="0" /> No
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="is_active">Course Active Duration <span
                                        class="text-danger">*</span></x-label>
                                <div id="ValidateCourseActiveDuration">
                                    <input type="hidden" name="validate_course_active_duration" value="0">
                                    <div class="d-flex justify-content-between">
                                        <span>
                                            <input type="text" name="active_from" class="form-control datepicker"
                                                autocomplete="off" placeholder="From Date"
                                                value="{{ old('active_from') }}"
                                                @if (old('is_active') && old('is_active') == 'on') disabled @endif />
                                        </span>
                                        <span>
                                            <input type="text" name="active_to" class="form-control datepicker"
                                                autocomplete="off" placeholder="To Date"
                                                value="{{ old('active_to') }}"
                                                @if (old('is_active') && old('is_active') == 'on') disabled @endif />
                                        </span>
                                        <span>
                                            <input type="checkbox" name="is_active"
                                                @if (old('is_active') && old('is_active') == 'on') checked @endif
                                                @if ((old('active_from') && old('active_from') !== '') || (old('active_to') && old('active_to') !== '')) disabled @endif /> Always
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Enable download course content</x-label>
                                <div class="form-control">
                                    <div class="d-flex justify-content-around">
                                        <span>
                                            <input type="radio" name="is_downloadable"
                                                {{ old('is_downloadable') && old('is_downloadable') == 1 ? 'checked' : '' }}
                                                value="1" @if (!old('is_downloadable')) checked @endif /> Yes
                                        </span>
                                        <span>
                                            <input type="radio" name="is_downloadable"
                                                {{ old('is_downloadable') && old('is_downloadable') == 0 ? 'checked' : '' }}
                                                value="0" /> No
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_en">Course Completion Tracking</x-label>
                                <div class="form-control">
                                    <div class="d-flex justify-content-around">
                                        <span>
                                            <input type="radio" name="is_course_completion_trackable"
                                                {{ old('is_course_completion_trackable') && old('is_course_completion_trackable') == 1 ? 'checked' : '' }}
                                                value="1" @if (!old('is_course_completion_trackable')) checked @endif /> Yes
                                        </span>
                                        <span>
                                            <input type="radio" name="is_course_completion_trackable"
                                                {{ old('is_course_completion_trackable') && old('is_course_completion_trackable') == 0 ? 'checked' : '' }}
                                                value="0" /> No
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Course Enrolment Required</x-label>
                                <div class="form-control">
                                    <div class="d-flex justify-content-around">
                                        <span>
                                            <input type="radio" name="is_enrolment_required"
                                                {{ old('is_enrolment_required') && old('is_enrolment_required') == 1 ? 'checked' : '' }}
                                                value="1" @if (!old('is_enrolment_required')) checked @endif /> Yes
                                        </span>
                                        <span>
                                            <input type="radio" name="is_enrolment_required"
                                                {{ old('is_enrolment_required') && old('is_enrolment_required') == 0 ? 'checked' : '' }}
                                                value="0" /> No
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.course_configurations.create'),
                        'clear' => true,
                        'back' => route('manage.course_configurations.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @php
        $course_categories = $course_categories->toJson();
    @endphp
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/moment/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}">
        </script>
        <script type="text/javascript">
            jQuery(function() {
                jQuery.validator.addMethod("ValidateCourseActiveDuration", function(value, element) {
                    return !($('input[name="active_from"]').val() == '' && $('input[name="active_to"]').val() ==
                        '' && !$('input[name="is_active"]').prop('checked'));
                }, "Select either Course Active Duration or check always.");

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        course_category_id: {
                            required: true,
                        },
                        course_category_courses_id: {
                            required: true,
                        },
                        validate_course_active_duration: {
                            ValidateCourseActiveDuration: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        course_category_id: {
                            required: 'Course Category is required.',
                        },
                        course_category_courses_id: {
                            required: 'Course is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "validate_course_active_duration") {
                            error.insertAfter("#ValidateCourseActiveDuration");
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });
            });

            function updateCourseActiveDuration() {
                let active_from = $('input[name="active_from"]').val();
                let active_to = $('input[name="active_to"]').val();
                let is_active = $('input[name="is_active"]').is(":checked");
                if (active_from != '' || active_to != '' || is_active == true) {
                    $('input[name="validate_course_active_duration"]').val(1);
                } else {
                    $('input[name="validate_course_active_duration"]').val(0);
                }
            }

            $('input[name="active_from"]').datepicker({
                //todayBtn:  1,
                format: 'dd-mm-yyyy',
                endDate: "+12m",
                startDate: "0",
                autoclose: true,
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('input[name="active_to"]').datepicker('setStartDate', minDate);
                $('input[name="active_from"]').valid();
                if (minDate) {
                    $('input[name="is_active"]').prop('disabled', true);
                    updateCourseActiveDuration();
                }
            });

            $('input[name="active_to"]').datepicker({
                //todayBtn:  1,
                format: 'dd-mm-yyyy',
                endDate: "+12m",
                startDate: new Date(),
                autoclose: true,
            }).on('changeDate', function(selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('input[name="active_from"]').datepicker('setEndDate', maxDate);
                $('input[name="active_to"]').valid();
                if (maxDate) {
                    $('input[name="is_active"]').prop('disabled', true);
                    updateCourseActiveDuration();
                }
            });

            $('input[name="active_from"], input[name="active_to"]').on("blur", function(e) {
                let active_from = $('input[name="active_from"]').val();
                let active_to = $('input[name="active_to"]').val();
                if (active_from == '' && active_to == '') {
                    $('input[name="is_active"]').prop('disabled', false);
                    updateCourseActiveDuration();
                }
            });
            $('input[name="is_active"]').on("click", function() {
                $('input[name="active_from"], input[name="active_to"]').prop('disabled', $(this).is(":checked"));
                updateCourseActiveDuration();
            });

            let course_categories = JSON.parse('<?php echo $course_categories; ?>');

            $("#course_category_id").on("change", function() {
                loader.show();
                setTimeout(() => {
                    let course_category_id = $(this).val();
                    let html = '<option value="">Select Course</option>';
                    course_categories.forEach(course_category => {
                        if (course_category.id == course_category_id && course_category.courses) {
                            course_category.courses.forEach(course => {
                                html +=
                                    `<option value="${course.id}">${course.course_name_en}</option>`;
                            });
                        }
                    });
                    $("#course_category_courses_id").html(html);
                    loader.hide();
                }, 500);
            });

            $(".is_upload").on("click", function() {
                let name = $(this).attr('name');
                $(`input[name="${name+"_required"}"]`).prop('checked', false);
                if ($(this).is(':checked')) {
                    $(`input[name="${name+"_required"}"]`).closest('span').show();
                } else {
                    $(`input[name="${name+"_required"}"]`).closest('span').hide();
                }
            });
        </script>
    @endpush
</x-admin-layout>

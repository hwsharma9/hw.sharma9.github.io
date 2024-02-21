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
                {{ __('Edit Course Configuration') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.course_configurations.edit', ['course_configuration' => $course_configuration->id]) }}"
                id="quickForm">
                @csrf
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
                                            {{ old('course_category_id', $course_configuration->fk_course_category_id) == $course_category->id ? 'selected' : '' }}>
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
                                @if (old('course_category_id', $course_configuration->fk_course_category_id) && $course_categories)
                                    @php
                                        $cc = $course_categories->where('id', old('course_category_id', $course_configuration->fk_course_category_id))->first();
                                    @endphp
                                    @if ($cc)
                                        @foreach ($cc->courses as $course_category)
                                            <option value="{{ $course_category->id }}"
                                                {{ old('course_category_courses_id', $course_configuration->fk_course_category_courses_id) == $course_category->id ? 'selected' : '' }}>
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
                                    @php
                                        $is_upload_pdf = old('is_upload_pdf', $course_configuration->is_upload_pdf) && in_array(old('is_upload_pdf', $course_configuration->is_upload_pdf), ['on', 1]);
                                        $is_upload_video = old('is_upload_video', $course_configuration->is_upload_video) && in_array(old('is_upload_video', $course_configuration->is_upload_video), ['on', 1]);
                                        $is_upload_ppt = old('is_upload_ppt', $course_configuration->is_upload_ppt) && in_array(old('is_upload_ppt', $course_configuration->is_upload_ppt), ['on', 1]);
                                        $is_upload_doc = old('is_upload_doc', $course_configuration->is_upload_doc) && in_array(old('is_upload_doc', $course_configuration->is_upload_doc), ['on', 1]);

                                        $is_upload_pdf_required = old('is_upload_pdf_required', $course_configuration->is_upload_pdf_required) && in_array(old('is_upload_pdf_required', $course_configuration->is_upload_pdf_required), ['on', 1]);
                                        $is_upload_video_required = old('is_upload_video_required', $course_configuration->is_upload_video_required) && in_array(old('is_upload_video_required', $course_configuration->is_upload_video_required), ['on', 1]);
                                        $is_upload_ppt_required = old('is_upload_ppt_required', $course_configuration->is_upload_ppt_required) && in_array(old('is_upload_ppt_required', $course_configuration->is_upload_ppt_required), ['on', 1]);
                                        $is_upload_doc_required = old('is_upload_doc_required', $course_configuration->is_upload_doc_required) && in_array(old('is_upload_doc_required', $course_configuration->is_upload_doc_required), ['on', 1]);
                                    @endphp
                                    <span>
                                        <span class="w-25">
                                            <input type="checkbox" name="is_upload_pdf" class="is_upload"
                                                {{ (int) $is_upload_pdf == 1 ? 'checked' : '' }} />
                                            Upload content in pdf file
                                        </span>
                                        <span
                                            style="{{ $is_upload_pdf || $is_upload_pdf_required ? '' : 'display:none' }}">
                                            <input type="checkbox" name="is_upload_pdf_required"
                                                data-ischeck="{{ (int) $is_upload_pdf_required }}"
                                                {{ (int) $is_upload_pdf_required == 1 ? 'checked' : '' }} />
                                            Is Mandatory
                                        </span>
                                    </span>
                                    <span>
                                        <span class="w-25">
                                            <input type="checkbox" name="is_upload_video" class="is_upload"
                                                {{ (int) $is_upload_video == 1 ? 'checked' : '' }} />
                                            Upload video content
                                        </span>
                                        <span
                                            style="{{ $is_upload_video || $is_upload_video_required ? '' : 'display:none' }}">
                                            <input type="checkbox" name="is_upload_video_required"
                                                data-ischeck="{{ (int) $is_upload_video_required }}"
                                                {{ (int) $is_upload_video_required == 1 ? 'checked' : '' }} />
                                            Is Mandatory
                                        </span>
                                    </span>
                                    <span>
                                        <span class="w-25">
                                            <input type="checkbox" name="is_upload_ppt" class="is_upload"
                                                {{ (int) $is_upload_ppt == 1 ? 'checked' : '' }} />
                                            Upload ppt contents
                                        </span>
                                        <span
                                            style="{{ $is_upload_ppt || $is_upload_ppt_required ? '' : 'display:none' }}">
                                            <input type="checkbox" name="is_upload_ppt_required"
                                                data-ischeck="{{ (int) $is_upload_ppt_required }}"
                                                {{ (int) $is_upload_ppt_required == 1 ? 'checked' : '' }} />
                                            Is Mandatory
                                        </span>
                                    </span>
                                    <span>
                                        <span class="w-25">
                                            <input type="checkbox" name="is_upload_doc" class="is_upload"
                                                {{ (int) $is_upload_doc == 1 ? 'checked' : '' }} />
                                            Upload contents in doc file
                                        </span>
                                        <span
                                            style="{{ $is_upload_doc || $is_upload_doc_required ? '' : 'display:none' }}">
                                            <input type="checkbox" name="is_upload_doc_required"
                                                data-ischeck="{{ (int) $is_upload_doc_required }}"
                                                {{ (int) $is_upload_doc_required == 1 ? 'checked' : '' }} />
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
                                            {{ old('is_visible', $course_configuration->is_visible) && old('is_visible', $course_configuration->is_visible) == 1 ? 'checked' : '' }}
                                            value="1" @if (!old('is_visible', $course_configuration->is_visible)) checked @endif />
                                        Yes
                                    </span>
                                    <span>
                                        <input type="radio" name="is_visible"
                                            {{ old('is_visible', $course_configuration->is_visible) == 0 ? 'checked' : '' }}
                                            value="0" /> No
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="is_active">Course Active Duration <span class="text-danger">*</span></x-label>
                            <div id="ValidateCourseActiveDuration">
                                <input type="hidden" name="validate_course_active_duration" value="0">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <input type="text" name="active_from" class="form-control datepicker"
                                            autocomplete="off" placeholder="From Date"
                                            value="{{ date_convert(old('active_from', $course_configuration->active_from), 'd-m-Y') }}"
                                            @if (old('is_active', $course_configuration->is_active) &&
                                                    in_array(old('is_active', $course_configuration->is_active), ['on', 1])) disabled @endif />
                                    </span>
                                    <span>
                                        <input type="text" name="active_to" class="form-control datepicker"
                                            autocomplete="off" placeholder="To Date"
                                            value="{{ date_convert(old('active_to', $course_configuration->active_to), 'd-m-Y') }}"
                                            @if (old('is_active', $course_configuration->is_active) &&
                                                    in_array(old('is_active', $course_configuration->is_active), ['on', 1])) disabled @endif />
                                    </span>
                                    <span>
                                        <input type="checkbox" name="is_active"
                                            @if (old('is_active', $course_configuration->is_active) &&
                                                    in_array(old('is_active', $course_configuration->is_active), ['on', 1])) checked @endif
                                            @if (
                                                (old('active_from', $course_configuration->active_from) &&
                                                    old('active_from', $course_configuration->active_from) !== '') ||
                                                    (old('active_to', $course_configuration->active_to) &&
                                                        old('active_to', $course_configuration->active_to) !== '')) disabled @endif /> Always
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
                                            {{ old('is_downloadable', $course_configuration->is_downloadable) && old('is_downloadable', $course_configuration->is_downloadable) == 1 ? 'checked' : '' }}
                                            value="1" @if (!old('is_downloadable', $course_configuration->is_downloadable)) checked @endif /> Yes
                                    </span>
                                    <span>
                                        <input type="radio" name="is_downloadable"
                                            {{ old('is_downloadable', $course_configuration->is_downloadable) == 0 ? 'checked' : '' }}
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
                                            {{ old('is_course_completion_trackable', $course_configuration->is_course_completion_trackable) && old('is_course_completion_trackable', $course_configuration->is_course_completion_trackable) == 1 ? 'checked' : '' }}
                                            value="1" @if (!old('is_course_completion_trackable', $course_configuration->is_course_completion_trackable)) checked @endif /> Yes
                                    </span>
                                    <span>
                                        <input type="radio" name="is_course_completion_trackable"
                                            {{ old('is_course_completion_trackable', $course_configuration->is_course_completion_trackable) == 0 ? 'checked' : '' }}
                                            value="0" /> No
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.status-dropdown :selected="$course_configuration->status" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.course_configurations.edit', $course_configuration->id),
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
            updateCourseActiveDuration();

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
                }
                updateCourseActiveDuration();
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
                let old_value = $(`input[name="${name+"_required"}"]`).attr('data-ischeck');
                old_value = old_value == 1 ? true : false;
                $(`input[name="${name+"_required"}"]`).prop('checked', old_value);
                if ($(this).is(':checked')) {
                    $(`input[name="${name+"_required"}"]`).closest('span').show();
                } else {
                    $(`input[name="${name+"_required"}"]`).closest('span').hide();
                }
            });
        </script>
    @endpush
</x-admin-layout>

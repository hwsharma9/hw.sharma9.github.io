<x-admin-layout>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course Category\'s Course') }}</li>
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
                {{ __('Edit Course Category\'s Course') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.course_category_courses.edit', ['course_category_course' => $course_category_course->id]) }}"
                id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="course_category">Course Category</x-label>
                                <select name="course_category" id="course_category" class="form-control">
                                    <option value="">Select Course Category</option>
                                    @if ($course_categories)
                                        @foreach ($course_categories as $course_category)
                                            <option value="{{ $course_category->id }}"
                                                {{ old('course_category', $course_category_course->fk_course_category_id) == $course_category->id ? 'selected' : '' }}>
                                                {{ $course_category->category_name_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="course_name_hi">Course Name (Hindi) <span
                                        class="text-danger">*</span></x-label>
                                <input type="text" name="course_name_hi" class="form-control" id="course_name_hi"
                                    placeholder="Enter Title in Hindi"
                                    value="{{ old('course_name_hi', $course_category_course->course_name_hi) }}"
                                    style="width: 100%;" />
                                <x-input-error name="course_name_hi" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="course_name_en">Course Name (English) <span
                                        class="text-danger">*</span></x-label>
                                <input type="text" name="course_name_en" class="form-control" id="course_name_en"
                                    placeholder="Enter Title in Hindi"
                                    value="{{ old('course_name_en', $course_category_course->course_name_en) }}"
                                    style="width: 100%;" />
                                <x-input-error name="course_name_en" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="$course_category_course->status" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.course_category_courses.edit', $course_category->id),
                        'clear' => true,
                        'back' => route('manage.course_category_courses.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                var validator = jQuery("#quickForm").validate({
                    rules: {
                        department: {
                            required: true,
                        },
                        course_name_hi: {
                            required: true,
                        },
                        course_name_en: {
                            required: true,
                        },
                        captcha: {
                            required: false,
                        },
                    },
                    messages: {
                        department: {
                            required: 'Department is required.',
                        },
                        course_name_hi: {
                            required: 'Title in Hindi is required.',
                        },
                        course_name_en: {
                            required: 'Title in English is required.',
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

                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            });
        </script>
    @endpush
</x-admin-layout>

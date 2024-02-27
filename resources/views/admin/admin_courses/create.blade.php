<x-admin-layout>

    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Admin Course') }}</li>
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
                {{ __('ADD Admin Course') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.admin_courses.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="admin">Content Manager</x-label>
                                <select name="admin" id="admin" class="form-control">
                                    <option value="">Select Content Manager</option>
                                    @if ($content_managers)
                                        @foreach ($content_managers as $content_manager)
                                            <option value="{{ $content_manager->id }}"
                                                {{ old('admin') == $content_manager->id ? 'selected' : '' }}>
                                                {{ $content_manager->name . ' (' . $content_manager->username . ')' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="course_category_courses_id">Course</x-label>
                                <select name="course_category_courses_id" id="course_category_courses_id"
                                    class="form-control">
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
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.admin_courses.create'),
                        'clear' => true,
                        'back' => route('manage.admin_courses.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        admin: {
                            required: true,
                        },
                        course_category_id: {
                            required: true,
                        },
                        course_category_courses_id: {
                            required: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        admin: {
                            required: 'Content Manager is required.',
                        },
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
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });

                let course_categories = JSON.parse('<?php echo $course_categories; ?>');
                $("#course_category_id").on("change", function() {
                    loader.show();
                    setTimeout(() => {
                        let course_category_id = $(this).val();
                        let html = '<option value="">Select Course</option>';
                        course_categories.forEach(course_category => {
                            if (course_category.id == course_category_id && course_category
                                .courses) {
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
            });
        </script>
    @endpush
</x-admin-layout>

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
                            <li class="breadcrumb-item active">{{ __('Course Category') }}</li>
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
                {{ __('Edit Course Category') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.course_categories.edit', ['course_category' => $course_category->id]) }}"
                id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="department">Department</x-label>
                                <div class="select2-purple" id="department_input">
                                    <select name="department" id="department" class="select2"
                                        data-placeholder="Select Department" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;">
                                        <option value="">Select Department</option>
                                        @if ($departments)
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department', $course_category->fk_department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->title_en }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="category_name_hi">Category Name (Hindi) <span
                                        class="text-danger">*</span></x-label>
                                <input type="text" name="category_name_hi" class="form-control" id="category_name_hi"
                                    placeholder="Enter Title in Hindi"
                                    value="{{ old('category_name_hi', $course_category->category_name_hi) }}"
                                    style="width: 100%;" />
                                <x-input-error name="category_name_hi" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="category_name_en">Category Name (English) <span
                                        class="text-danger">*</span></x-label>
                                <input type="text" name="category_name_en" class="form-control" id="category_name_en"
                                    placeholder="Enter Title in Hindi"
                                    value="{{ old('category_name_en', $course_category->category_name_en) }}"
                                    style="width: 100%;" />
                                <x-input-error name="category_name_en" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="$course_category->status" />
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
                        'update_back' => route('manage.course_categories.edit', $course_category->id),
                        'clear' => true,
                        'back' => route('manage.course_categories.index'),
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
                        category_name_hi: {
                            required: true,
                        },
                        category_name_en: {
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
                        category_name_hi: {
                            required: 'Title in Hindi is required.',
                        },
                        category_name_en: {
                            required: 'Title in English is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "department") {
                            error.insertAfter("#department_input");
                        } else {
                            error.insertAfter(element);
                        }
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

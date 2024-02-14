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
                {{ __('ADD Course Category') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.course_categories.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    @if ($departments)
                        @if ($departments->count() == 1)
                            <input type="hidden" name="department"
                                value="{{ $departments->pluck('id')->implode(',') }}" />
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="department">Department</x-label>
                                        <div class="select2-purple" id="department_input">
                                            <select name="department" id="department" class="select2"
                                                data-placeholder="Select Department"
                                                data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                <option value="">Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ old('department') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->title_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="html_detail mt-3">
                        @if (old('category_name_hi'))
                            @foreach (old('category_name_hi') as $key => $item)
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <x-label for="category_name_hi">Category Name (Hindi) <span
                                                    class="text-danger">*</span></x-label>
                                            <input type="text" name="category_name_hi[]" class="form-control"
                                                placeholder="Enter Title in Hindi"
                                                value="{{ old('category_name_hi')[$key] }}" style="width: 100%;" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-label for="category_name_en">Category Name (English) <span
                                                    class="text-danger">*</span></x-label>
                                            <input type="text" name="category_name_en[]" class="form-control"
                                                placeholder="Enter Title in English"
                                                value="{{ old('category_name_en')[$key] }}" style="width: 100%;" />
                                        </div>
                                    </div>
                                    <div class="col-1 form-group">
                                        @if ($loop->first)
                                            <button type="button"
                                                class="btn btn-primary btn-icon-anim btn-square add_html"><i
                                                    class="fa fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                class="btn btn-danger btn-icon-anim btn-square remove_html"><i
                                                    class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <x-label for="category_name_hi">Category Name (Hindi) <span
                                                class="text-danger">*</span></x-label>
                                        <input type="text" name="category_name_hi[]" class="form-control"
                                            placeholder="Enter Title in Hindi" value="{{ old('category_name_hi') }}"
                                            style="width: 100%;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="category_name_en">Category Name (English) <span
                                                class="text-danger">*</span></x-label>
                                        <input type="text" name="category_name_en[]" class="form-control"
                                            placeholder="Enter Title in English" value="{{ old('category_name_en') }}"
                                            style="width: 100%;" />
                                    </div>
                                </div>
                                <div class="col-1 form-group">
                                    <button type="button" class="btn btn-primary btn-icon-anim btn-square add_html"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                        @endif
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
                        'create' => true,
                        'create_back' => route('manage.course_categories.create'),
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
                        'category_name_hi[]': {
                            required: true,
                        },
                        'category_name_en[]': {
                            required: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        department: {
                            required: 'Department is required.',
                        },
                        'category_name_hi[]': {
                            required: 'Title in Hindi is required.',
                        },
                        'category_name_en[]': {
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

                $(".add_html").on("click", function() {
                    var html = $(this).closest(".row").clone();
                    html.find("input,textarea").val("");
                    html.find(".add_html").removeClass("add_html btn-primary").addClass(
                        "remove_html btn-danger");
                    html.find(".fa-plus").removeClass("fa-plus").addClass("fa-trash").closest(".row");
                    html.find('label.error').remove();
                    $(this).closest(".html_detail").append(html);
                });
                $("body").on("click", ".remove_html", function() {
                    $(this).closest(".row").remove();
                });
            });
        </script>
    @endpush
</x-admin-layout>

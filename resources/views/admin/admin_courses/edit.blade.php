<x-admin-layout>

    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Admin Course') }}</li>
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
                {{ __('Edit Admin Course') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.admin_courses.edit', ['admin_course' => $admin_course->id]) }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="admin">Content Manager</x-label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $admin_course->admin->name . '(' . $admin_course->admin->username . ')' }}" />
                                {{-- <select name="admin" id="admin" class="form-control">
                            <option value="">Select Content Manager</option>
                            @if ($content_managers)
                                @foreach ($content_managers as $content_manager)
                                    <option value="{{$content_manager->id}}" {{old('admin') == $content_manager->id ? 'selected' : ''}}>{{$content_manager->name . ' ('.$content_manager->username.')'}}</option>
                                @endforeach
                            @endif
                        </select> --}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="course_category_id">Course Category</x-label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $admin_course->courseCategory->category_name_en }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="course">Course</x-label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $admin_course->categoryCourse->course_name_en }}" />
                                {{-- <select name="course" id="course" class="form-control">
                            <option value="">Select Course</option>
                            @if ($courses)
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}" {{old('course') == $course->id ? 'selected' : ''}}>{{$course->course_name_en}}</option>
                                @endforeach
                            @endif
                        </select> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="$admin_course->status" />
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
                        'update_back' => route('manage.admin_courses.edit', $admin_course->id),
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
                        course: {
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
                        course: {
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

                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            });
        </script>
    @endpush
</x-admin-layout>

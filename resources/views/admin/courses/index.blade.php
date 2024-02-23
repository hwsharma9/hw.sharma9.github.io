<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('webroot/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @endpush
    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
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
        <x-admin.container-card :showmessage="false">
            <x-slot name="title">
                {{ __('Course Search') }}
            </x-slot>

            <form action="" method="GET" id="search_form">
                <fieldset class="col-md-12" style="border: solid; 1px;">
                    <legend>Course Search</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="category">Category</x-label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @if ($course_categories)
                                        @foreach ($course_categories as $course_category)
                                            <option value="{{ $course_category->id }}">
                                                {{ $course_category->category_name_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="course_category_courses_id">Course <span
                                        class="text-danger">*</span></x-label>
                                <select name="course_category_courses_id" id="course_category_courses_id"
                                    class="form-control" style="width: 100%;">
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <x-label for="course_status">Course Status<span class="text-danger">*</span></x-label>
                            <select name="course_status" id="course_status" class="form-control" style="width: 100%;">
                                <option value="">Select Course Status</option>
                                @foreach (config('constents.course_status') as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <x-label for="content_manager">Content Manager<span class="text-danger">*</span></x-label>
                            <select name="content_manager" id="content_manager" class="form-control"
                                style="width: 100%;">
                                <option value="">Select Content Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <button class="btn btn-primary">Search</button>
                            <button class="btn btn-primary" type="button" id="clear_form">Clear</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </x-admin.container-card>
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Course List') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Category</th>
                        <th>Course</th>
                        <th>Last Modified By</th>
                        <th>Last Modified On</th>
                        <th>Course Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('manage.courses.index') }}",
                        data: function(d) {
                            const search_data = {}
                            $("#search_form").serializeArray()
                                .filter(row => row.value != "")
                                .forEach(row => {
                                    search_data[row.name] = row.value;
                                });
                            d.filter = search_data;
                        }
                    },
                    order: [0, 'desc'],
                    columns: [{
                            data: row => row.DT_RowIndex,
                            name: 'id'
                        },
                        {
                            data: 'assigned_admin.course_category.category_name_en',
                            name: 'assignedAdmin.courseCategory.category_name_en'
                        },
                        {
                            data: 'assigned_admin.category_course.course_name_en',
                            name: 'assignedAdmin.categoryCourse.course_name_en'
                        },
                        {
                            data: 'editor_name',
                            name: 'editor.first_name',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'course_status',
                            name: 'course_status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $("#search_form").on("submit", function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                });
                $("#clear_form").on("click", function(e) {
                    $('#search_form').trigger("reset");
                    $('#content_manager').append({}).trigger('change');
                    table.ajax.reload();
                });

                let course_categories = JSON.parse('<?php echo $course_categories; ?>');
                $("#category").on("change", function() {
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

                $(document).on('submit', 'form[name="course_status_form"]', function(e) {
                    e.preventDefault();
                    let that = $(this);
                    that.find('button.publish_course').prop('disabled', true);
                    let url = $(this).attr('action');
                    $.ajax({
                        url: url,
                        data: $(this).serialize(),
                        method: 'POST',
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
                                table.ajax.reload();
                            }
                            // that.find('button.publish_course').hasClass('disabled') ? that.find(
                            //     'button.publish_course').addClass('disabled') : that.find(
                            //     'button.publish_course').removeClass('disabled');
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                });

                // $(document).on("click", ".publish_course", function() {
                // $('form[name="course_status_form"]').submit();
                // console.log($(this).attr('disabled'));
                // ($(this).attr('disabled') == 'undefined') ? $(this).prop('disabled', true): $(this).prop(
                //     'disabled', false);
                // $(this).closest('form').submit();
                // });

                $('#content_manager').select2({
                    theme: 'bootstrap4',
                    ajax: {
                        url: "{{ route('ajax.get-content-managers') }}",
                        method: 'GET',
                        silently: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        processResults: function(data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.records
                            };
                        }
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>

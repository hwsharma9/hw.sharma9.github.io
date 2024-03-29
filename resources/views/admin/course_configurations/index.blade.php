<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('webroot/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
    @endpush
    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course Configuration') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.course_configurations.create'))
                                <a href="{{ route('manage.course_configurations.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="content">
        <x-admin.container-card :showmessage="false">
            <x-slot name="title">
                {{ __('Course Configuration Search') }}
            </x-slot>

            <div class="card-body">
                <form action="" method="GET" id="search_form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="course_category_id">Category</x-label>
                                <select name="course_category_id" id="course_category_id" class="form-control">
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
                            <x-admin.status-dropdown :search="true" :required="false" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <button class="btn btn-primary">Search</button>
                            <button class="btn btn-secondary" type="button" id="clear_form">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-admin.container-card>
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Course Configuration List') }}
            </x-slot>

            <div class="card-body">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Category Name</th>
                            <th>Course Name</th>
                            <th>Last Modified By</th>
                            <th>Last Modified On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </x-admin.container-card>
    </x-slot>
    @php
        $course_categories = $course_categories->toJson();
    @endphp
    @push('scripts')
        <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('manage.course_configurations.index') }}",
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
                            data: 'course_category.category_name_en',
                            name: 'courseCategory.category_name_en'
                        },
                        {
                            data: 'category_course.course_name_en',
                            name: 'categoryCourse.course_name_en'
                        },
                        {
                            data: 'editor_name',
                            name: 'editor.first_name'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
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
                    table.ajax.reload();
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

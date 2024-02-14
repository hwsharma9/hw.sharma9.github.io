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
                            <li class="breadcrumb-item active">{{ __('Course Category') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.course_categories.create'))
                                <a href="{{ route('manage.course_categories.create') }}" class="btn btn-primary"><i
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
                {{ __('Course Category Search') }}
            </x-slot>

            <form action="" method="GET" id="search_form">
                <fieldset class="col-md-12" style="border: solid; 1px;">
                    <legend>Course Category Search</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="department">Department</x-label>
                                <select name="department" id="department" class="form-control">
                                    <option value="">Select Department</option>
                                    @if ($departments)
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->title_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="category_name">Category Name</x-label>
                                <input type="text" name="category_name" class="form-control" id="category_name"
                                    placeholder="Enter Category Name" value="" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <x-admin.status-dropdown :search="true" :required="false" />
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
                {{ __('Course Category List') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Department</th>
                        <th>Category Name (English)</th>
                        <th>Category Name (Hindi)</th>
                        <th>Last Modified By</th>
                        <th>Last Modified On</th>
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
        <script type="text/javascript">
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('manage.course_categories.index') }}",
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
                            data: 'department.title_en',
                            name: 'department.title_en'
                        },
                        {
                            data: 'category_name_en_link',
                            name: 'category_name_en'
                        },
                        {
                            data: 'category_name_hi',
                            name: 'category_name_hi'
                        },
                        {
                            data: 'editor_name',
                            name: 'editor.first_name',
                            orderable: false
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
            });
        </script>
    @endpush
</x-admin-layout>

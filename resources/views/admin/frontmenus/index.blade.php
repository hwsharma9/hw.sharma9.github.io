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
                            <li class="breadcrumb-item active">{{ __('Front Menu Module') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.frontmenumodules.create'))
                                <a href="{{ route('manage.frontmenumodules.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-slot>
    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('FRONT MENU MODULE LIST') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Title</th>
                        <th>Controller Name</th>
                        <th>Function Name</th>
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
        <script>
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('manage.dbcontrollers.index') }}",
                    order: [0, 'desc'],
                    columns: [{
                            data: function(a, b, c, d) {
                                let start = parseInt(d.settings.json.input.start)
                                return (start > 0) ? (start + (d.row + 1)) : (d.row + 1);
                            },
                            name: 'id'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: function(row) {
                                return row.resides_at + "\\" + row.controller_name;
                            },
                            name: 'controller_name',
                            searchable: false
                        },
                        {
                            data: 'function_names',
                            name: 'function_names'
                        },
                        {
                            data: 'status',
                            name: 'status',
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
            });
        </script>
    @endpush
</x-admin-layout>

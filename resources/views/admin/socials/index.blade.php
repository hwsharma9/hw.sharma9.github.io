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
                            <li class="breadcrumb-item active">{{ __('Admin Users List') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.admins.create'))
                                <a href="{{ route('manage.admins.create') }}" class="btn btn-primary"><i
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
                {{ __('ADMIN USERS LIST') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>First Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>User Privilege</th>
                        <th>Last Modified Date</th>
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
        <script src="//cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> --}}
        <script type="text/javascript">
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('manage.admins.index') }}",
                    order: [0, 'desc'],
                    columns: [{
                            data: function(a, b, c, d) {
                                let start = parseInt(d.settings.json.input.start)
                                return (start > 0) ? (start + (d.row + 1)) : (d.row + 1);
                            },
                            name: 'id'
                        },
                        {
                            data: function(row) {
                                return row.first_name + ' ' + row.last_name;
                            },
                            name: 'name',
                            searchable: false
                        },
                        {
                            data: 'designation',
                            name: 'designation'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'mobile',
                            name: 'mobile'
                        },
                        {
                            data: function(row) {
                                let role_names = row['roles'].map(role => role.name).join(', ');
                                return role_names;
                            },
                            name: 'role',
                            searchable: false
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    // 'createdRow': function( row, data, dataIndex ) {
                    // if (data['deleted_at'] != null) {
                    // $(row).addClass( 'bg-danger' ).attr('title', 'Model has been deleted!');
                    //  }
                    // }
                });
            });
            // dom: 'Bfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ]
        </script>
    @endpush
</x-admin-layout>

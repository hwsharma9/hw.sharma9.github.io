<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('webroot/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/daterangepicker/daterangepicker.css') }}">
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
        <x-admin.container-card :showmessage="false">
            <x-slot name="title">
                {{ __('Admin Search') }}
            </x-slot>

            <div class="card-body">
                <form action="{{ route('manage.admins.index') }}" method="GET" id="search_form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="name">Name</x-label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter Name" value="" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="email">Email</x-label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Enter Email" value="" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="username">Employee Code</x-label>
                                <input type="text" name="username" class="form-control" id="username"
                                    placeholder="Enter Employee Code" value="" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <x-admin.status-dropdown :search="true" :required="false" />
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="role_id">Role</x-label>
                                <select name="role_id" class="form-control">
                                    <option value="">Select Role</option>
                                    @if ($roles)
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="office">Office</x-label>
                                <select name="office_id" id="office_id" class="form-control">
                                    <option value="">Select Office</option>
                                    @if ($offices)
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}">{{ $office->office->title_en }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
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
                {{ __('ADMIN USERS LIST') }}
            </x-slot>

            <div class="card-body">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No.</th>
                            <th>Role</th>
                            <th>Office</th>
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
    @push('scripts')
        <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/daterangepicker/daterangepicker.js') }}"></script>
        {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> --}}
        <script type="text/javascript">
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('manage.admins.index') }}",
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
                            data: row => row.name + ' (' + row.username + ')',
                            name: 'first_name'
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
                                let role_names = row['admin_roles'].map(admin_roles => admin_roles[
                                    'role'].name).join(', ')
                                return role_names;
                            },
                            name: 'roles.name',
                            orderable: false
                        },
                        {
                            data: 'officeonboarding',
                            name: 'officeonboarding.office.title_en',
                            orderable: false
                        },
                        {
                            data: 'editor_name',
                            name: 'editor.first_name',
                            orderable: false,
                            searchable: false
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

                $('#updated_at').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    autoUpdateInput: false,
                    locale: {
                        format: 'YYYY-MM-DD HH:mm:ss',
                        cancelLabel: 'Clear'
                    }
                });
                $('input[name="updated_at"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format(
                        'YYYY-MM-DD HH:mm:ss'));
                });
            });
        </script>
    @endpush
</x-admin-layout>

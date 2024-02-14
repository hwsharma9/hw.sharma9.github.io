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
                            <li class="breadcrumb-item active">{{ __('Access List') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.dbcontrollers.create'))
                                <a href="{{ route('manage.dbcontrollers.create') }}" class="btn btn-primary"><i
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
                {{ __('Access List Search') }}
            </x-slot>

            <form action="{{ route('manage.officeonboardings.index') }}" method="GET" id="search_form">
                <fieldset class="col-md-12" style="border: solid; 1px;">
                    <legend>Access List Search</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="title">Title</x-label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Enter Title" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="resides_at">Controller Location</x-label>
                                <select name="resides_at" class="form-control">
                                    <option value="">Select Location</option>
                                    @if (config('constents.resides_at'))
                                        @foreach (config('constents.resides_at') as $resides_at)
                                            <option value="{{ $resides_at }}">
                                                {{ ucfirst($resides_at == 'manage' ? 'admin' : $resides_at) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="resides_at" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="controller_name">Controller</x-label>
                                <input type="text" name="controller_name" class="form-control text-capitalize"
                                    id="controller_name" placeholder="Enter Controller Name" />
                                <x-input-error name="controller_name" />
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
                {{ __('ACCESS LIST') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Title</th>
                        <th>Controller Name</th>
                        <th>Function Name</th>
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
        <script src="{{ asset('webroot/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script>
            $(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('manage.dbcontrollers.index') }}",
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
                            data: 'editor_name',
                            name: 'editor_name'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
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

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
                            <li class="breadcrumb-item active">{{ __('Office Onboarding') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.officeonboardings.create'))
                                <a href="{{ route('manage.officeonboardings.create') }}" class="btn btn-primary"><i
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
                {{ __('Office Onboarding Search') }}
            </x-slot>

            <form action="{{ route('manage.officeonboardings.index') }}" method="GET" id="search_form">
                <fieldset class="col-md-12" style="border: solid; 1px;">
                    <legend>Office Onboarding Search</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="department">Department</x-label>
                                <select name="department_id" id="department_id" class="form-control">
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
                                <x-label for="office">Office</x-label>
                                <select name="office_id" id="office_id" class="form-control">
                                    <option value="">Select Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="nodal_name">Nodal Name</x-label>
                                <input type="text" name="nodal_name" class="form-control" id="nodal_name"
                                    placeholder="Enter Nodal Name" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="nodal_email">Nodal Email</x-label>
                                <input type="text" name="nodal_email" class="form-control" id="nodal_email"
                                    placeholder="Enter Nodal Email" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="nodal_contact_number">Nodal Contact Number</x-label>
                                <input type="text" name="nodal_contact_number" class="form-control"
                                    id="nodal_contact_number" placeholder="Enter Nodal Contact Number" />
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
                {{ __('Office Onboarding List') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Office</th>
                        <th>Department</th>
                        <th>Nodel Name</th>
                        <th>Nodel Email</th>
                        <th>Nodel Contact Number</th>
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
                    ajax: {
                        url: "{{ route('manage.officeonboardings.index') }}",
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
                            data: 'office.title_en',
                            name: 'office.title_en'
                        },
                        {
                            data: 'department.title_en',
                            name: 'department.title_en'
                        },
                        {
                            data: 'nodal_name',
                            name: 'nodal_name'
                        },
                        {
                            data: 'nodal_email',
                            name: 'nodal_email'
                        },
                        {
                            data: 'nodal_contact_number',
                            name: 'nodal_contact_number'
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

                const offices = JSON.parse('<?php echo $offices->toJson(); ?>');
                $("#department_id").on("change", function() {
                    let value = $(this).val();
                    let office_options = '<option value="">Select Office</option>';
                    offices.forEach(office => {
                        if (office.fk_department_id == value) {
                            office_options +=
                                `<option value="${office.id}">${office.title_en}</option>`;
                        }
                    });
                    $("#office_id").html(office_options);
                });
            });
        </script>
    @endpush
</x-admin-layout>

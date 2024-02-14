<x-admin-layout>
    @push('styles')
        <link rel="stylesheet"
            href="{{ asset('webroot/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
            type="text/css" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="http://localhost/lease_mng_sys/webroot//plugins/bootstrap-datepicker/css/datepicker.css">
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Additional Role') }}</li>
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
                {{ __('Add Additional Role') }}
            </x-slot>

            <fieldset class="col-md-12">
                <legend>User Present Info:</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-label>Name</x-label>
                            <input class="form-control" disabled value="{{ $admin->name }}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-label for="role_id">Employee Code</x-label>
                            <input class="form-control" disabled value="{{ $admin->username }}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-label for="role_id">Role</x-label>
                            <input class="form-control" disabled value="{{ $admin->roles[0]->name }}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <x-label for="designation">Designation</x-label>
                            <input class="form-control" disabled value="{{ $admin->designation->name }}" />
                        </div>
                    </div>
                </div>
            </fieldset>
            <form method="POST" action="{{ route('manage.admin_roles.create', ['admin' => encrypt($admin->id)]) }}"
                id="quickForm" enctype="multipart/form-data">
                @csrf
                <fieldset class="col-md-12">
                    <legend>Assign New Role:</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="role">Role <span class="text-danger">*</span></x-label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="actual_admin_user_id">User <span class="text-danger">*</span></x-label>
                                <select name="actual_admin_user_id" id="actual_admin_user_id" class="form-control">
                                    <option value="">Select User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="from_date">From Date <span class="text-danger">*</span></x-label>
                                <input type="text" name="from_date" value="{{ old('from_date') }}" id="from_date"
                                    class="form-control datepicker" placeholder="Enter From Date" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="to_date">To Date <span class="text-danger">*</span></x-label>
                                <input type="text" name="to_date" value="{{ old('to_date') }}" id="to_date"
                                    class="form-control datepicker" placeholder="Enter To Date" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="fk_reason_id">Reason For Additional Charge <span
                                        class="text-danger">*</span></x-label>
                                <select name="fk_reason_id" id="fk_reason_id" class="form-control">
                                    <option value="">Select Reason</option>
                                    @foreach ($reasons as $reason)
                                        <option value="{{ $reason->id }}"
                                            {{ old('fk_reason_id') == $reason->id ? 'selected' : '' }}>
                                            {{ $reason->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="verification_doc">Upload Verification Document</x-label>
                                <div class="form-control">
                                    <input type="file" name="verification_doc" style="width: 100%;"
                                        id="verification_doc" />
                                </div>
                                <small>Max File Size is 500 KB and accepted File extension is
                                    .jpeg,.jpg,.png,.pdf</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="remark">Remark <span class="text-danger">*</span></x-label>
                                <textarea name="remark" id="remark" class="form-control" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.admin_roles.create', ['admin' => encrypt($admin->id)]),
                        'clear' => true,
                        'back' => route('manage.admin_roles.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
        <x-admin.container-card :showmessage="false">
            <x-slot name="title">
                {{ __('USER ACCESS LIST') }}
            </x-slot>

            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Role</th>
                        <th>Actual Name</th>
                        <th>Current Incharge User</th>
                        <th>Date (From - To)</th>
                        <th>Attachment</th>
                        <th>Status</th>
                        <th>Is Default</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($admin_roles)
                        @foreach ($admin_roles as $key => $admin_role)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $admin_role->role->name }}</td>
                                <td>{{ $admin_role->admin->name . ' - ' . $admin_role->admin->username }}</td>
                                <td>{{ $admin_role->actual_admin ? $admin_role->actual_admin->name . ' - ' . $admin_role->actual_admin->username : '-' }}
                                </td>
                                <td>
                                    @if (
                                        $admin_role['from_date'] &&
                                            $admin_role['from_date'] &&
                                            ($admin_role['to_date'] && $admin_role['to_date'] >= date('Y-m-d')))
                                        <span class="{{ 'date-' . $admin_role->id }}">
                                            {{ ($admin_role->from_date ? date('d-m-Y', strtotime($admin_role->from_date)) : '') .
                                                ' - ' .
                                                ($admin_role->to_date ? date('d-m-Y', strtotime($admin_role->to_date)) : '') }}
                                        </span>
                                        <button type="button" class="edit-admin-role"
                                            data-key="{{ $key }}"
                                            data-update_route="{{ route('manage.admin_roles.edit', ['admin' => encrypt($admin->id), 'admin_role' => encrypt($admin_role->id)]) }}"><i
                                                class="fas fa-edit"></i></button>
                                    @endif
                                </td>
                                <td>
                                    {{ $admin_role->upload ? $admin_role->upload->original_name : '' }}
                                </td>
                                <td>
                                    <p id="{{ 'current-status-of-' . $admin_role->id }}">
                                        {!! DisplayStatus($admin_role->status) !!}
                                    </p>
                                    @if (
                                        $admin_role['from_date'] &&
                                            $admin_role['from_date'] &&
                                            ($admin_role['to_date'] && $admin_role['to_date'] >= date('Y-m-d')))
                                        <form
                                            action="{{ route('ajax.update-addition-role-status', ['admin_role' => $admin_role->id]) }}"
                                            class="update-status">
                                            <select name="status">
                                                <option value="1"
                                                    {{ $admin_role->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="2"
                                                    {{ $admin_role->status == 2 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <button type="submit">Save</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{!! DefaultStatus($admin_role->is_default) !!}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </x-admin.container-card>
        <div class="modal fade" id="edit-admin-role">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="" method="POST" id="update-additional-charge" enctype="multipart/form-data"
                        data-key="">
                        @csrf
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title">{{ __('USER ACCESS') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="col-md-12">
                                <legend>Additional Charge Details</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">Name</x-label>
                                            <input class="form-control popup-name" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">Role</x-label>
                                            <input class="form-control popup-role" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">Reason</x-label>
                                            <input class="form-control popup-reason" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">From Date</x-label>
                                            <input class="form-control popup-from_date" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">To Date</x-label>
                                            <input class="form-control popup-to_date" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-label for="">Attachment</x-label>
                                            <input class="form-control popup-attachment" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-label for="">Remark</x-label>
                                            <input class="form-control popup-remark" disabled />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <hr />
                            <fieldset class="col-md-12">
                                <legend>Edit Additional Charge Date</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-label for="">From Date</x-label>
                                            <input class="form-control popup-from_date" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-label for="">To Date</x-label>
                                            <input type="text" name="to_date" value="" id="popup_to_date"
                                                class="form-control popup-to_date datepicker"
                                                placeholder="Enter To Date" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-label for="">Remark <span
                                                    class="text-danger">*</span></x-label>
                                            <textarea name="remark" class="form-control popup-remark" placeholder="Enter Remark"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-label for="verification_doc">Upload Verification Document</x-label>
                                            <div class="form-control">
                                                <input type="file" name="verification_doc" style="width: 100%;"
                                                    id="popup_verification_doc" />
                                            </div>
                                            <small>Max File Size is 500 KB and accepted File extension is
                                                .jpeg,.jpg,.png,.pdf</small>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script src="{{ asset('webroot/plugins/moment/moment.min.js') }}"></script>
        {{-- <script src="{{asset('webroot/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script> --}}
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript"
            src="http://localhost/lease_mng_sys/webroot//plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            jQuery(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });


                const has_old_role = '{{ old('role') }}';
                const has_actual_admin_user_id = '{{ old('actual_admin_user_id') }}';
                $("#remark").keyup(function() {
                    el = $(this);
                    if (el.val().length >= 250) {
                        el.val(el.val().substr(0, 250));
                    } else {
                        $("#charNum").text(250 - el.val().length);
                    }
                });

                $.validator.addMethod("checkdate", function(value, element) {
                    return this.optional(element) || /^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/
                        .test(value);
                }, "Please enter valid date format (DD-MM-YYYY).");

                $.validator.addMethod("afterBeginDate", function(value, element, param) {
                    var status = false;
                    if (($('#' + param[1]).data('datepicker').getDate() - $('#' + param[0]).data('datepicker')
                            .getDate()) < 0) {
                        status = false;
                    } else {
                        status = true;
                    }
                    return this.optional(element) || status;
                }, "To date should be greater than from date.");

                $.validator.addMethod("extension", function(value, element, param) {
                    param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
                    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
                }, $.validator.format("Please upload only PDF file."));

                $.validator.addMethod('filesize', function(value, element, param) {
                    return this.optional(element) || (element.files[0].size <= param)
                }, 'File size must be less than 500 KB');

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        role: {
                            required: true
                        },
                        actual_admin_user_id: {
                            required: true
                        },
                        from_date: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            checkdate: true,
                        },
                        to_date: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            checkdate: true,
                            afterBeginDate: ['from_date', 'to_date']
                        },
                        fk_reason_id: {
                            required: true
                        },
                        verification_doc: {
                            // required:true,
                            extension: "jpg|jpeg|png|pdf",
                            filesize: 512000
                        },
                        remark: {
                            required: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        role: "Role is Required",
                        actual_admin_user_id: {
                            required: 'User is required.',
                        },
                        from_date: {
                            required: 'From date is required.',
                        },
                        to_date: {
                            required: 'To date is required.',
                        },
                        fk_reason_id: {
                            required: 'Reason is required.',
                        },
                        verification_doc: {
                            // required:"Upload Supporting Document is required.",
                            extension: "Please upload .jpeg,.jpg,.JPG,.JPEG,.png files only.",
                            filesize: "Max File Size is 500 KB."
                        },
                        remark: {
                            required: 'Remark is required.',
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

                $("#update-additional-charge").validate({
                    rules: {
                        to_date: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            checkdate: true,
                        },
                        verification_doc: {
                            // required:true,
                            extension: "jpg|jpeg|png|pdf",
                            filesize: 512000
                        },
                        remark: {
                            required: true,
                        },
                    },
                    messages: {
                        to_date: {
                            required: 'To date is required.',
                        },
                        verification_doc: {
                            // required:"Upload Supporting Document is required.",
                            extension: "Please upload .jpeg,.jpg,.JPG,.JPEG,.png files only.",
                            filesize: "Max File Size is 500 KB."
                        },
                        remark: {
                            required: 'Remark is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    // submitHandler: function (form) {
                    //     var file_data = $('#popup_verification_doc')[0].files;
                    //     var form_data = new FormData(form); // All form data
                    //     $.ajax({
                    //         url: $(this).attr('action'),
                    //         method: 'POST',
                    //         data: form_data,
                    //         processData: false,
                    //         contentType: false,
                    //         success: function(result) {
                    //             Toast.fire({
                    //                 icon: result.status,
                    //                 title: result.message
                    //             });
                    //         },
                    //         error: function(error) {
                    //             console.log(error);
                    //         }
                    //     });
                    // 	// loader.show();
                    // 	// form.submit();
                    //     return false;
                    // }
                })

                $("#from_date").datepicker({
                    //todayBtn:  1,
                    format: 'dd-mm-yyyy',
                    endDate: "+12m",
                    startDate: "0",
                    autoclose: true,
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#to_date').datepicker('setStartDate', minDate);
                    $('#from_date').valid();
                });

                $("#to_date").datepicker({
                    //todayBtn:  1,
                    format: 'dd-mm-yyyy',
                    endDate: "+12m",
                    startDate: new Date(),
                    autoclose: true,
                }).on('changeDate', function(selected) {
                    var maxDate = new Date(selected.date.valueOf());
                    $('#from_date').datepicker('setEndDate', maxDate);
                    $("#to_date").valid();
                });

                $("#popup_to_date").datepicker({
                    //todayBtn:  1,
                    format: 'dd-mm-yyyy',
                    endDate: "+12m",
                    autoclose: true,
                });

                function createUsersList(role_id, is_select = false) {
                    const auth_id = '{{ $admin->id }}';
                    $.ajax({
                        url: "{{ route('ajax.users-by-role') }}",
                        method: 'POST',
                        data: {
                            role_id: role_id,
                            auth_id: auth_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            let html = '<option value="">Select Admin</option>';
                            if (result.records) {
                                result.records.forEach(record => {
                                    let select = "";
                                    // console.log(record.id, ' = ', is_select);
                                    if (is_select && record.id == is_select) {
                                        select = "selected='selected'";
                                    }
                                    html += `<option value="${record.id}" ${select}>
                                ${record.name + ' (' + record.username + ')'}
                            </option>`;
                                });
                            }
                            $("#actual_admin_user_id").html(html);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }

                $("#role").on("change", function() {
                    createUsersList($(this).val());
                });

                // console.log('has_old_role => ' + has_old_role);
                // console.log('has_actual_admin_user_id => ' + has_actual_admin_user_id);
                if (has_old_role && has_actual_admin_user_id) {
                    createUsersList(has_old_role, has_actual_admin_user_id);
                }

                $("form.update-status").on("submit", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'PATCH',
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            Toast.fire({
                                icon: result.status,
                                title: result.message
                            });
                            if (result.status = 'success') {
                                $("#current-status-of-" + result.admin_role_id).html(
                                    result.status_html
                                );
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });

                let admin_role = JSON.parse('<?php echo $admin_roles->toJson(); ?>');
                $("button.edit-admin-role").on("click", function() {
                    let key = $(this).attr('data-key');
                    let update_route = $(this).attr('data-update_route');
                    const role_data = admin_role[key];
                    $("#update-additional-charge").attr("action", update_route);

                    const popup_details = {
                        name: role_data.admin.name,
                        role: role_data.role.name,
                        from_date: moment(role_data.from_date).format('DD-MM-YYYY'),
                        to_date: moment(role_data.to_date).format('DD-MM-YYYY'),
                        reason: role_data.reason.name,
                        attachment: role_data.upload ? role_data.upload.original_name : '',
                        remark: role_data.remark,
                    };
                    for (const key in popup_details) {
                        if (Object.hasOwnProperty.call(popup_details, key)) {
                            const element = popup_details[key];
                            $(".popup-" + key).val(element);
                        }
                    }
                    $('#popup_to_date').datepicker('setStartDate', popup_details.to_date);
                    $("#edit-admin-role").modal("show");
                    $("#update-additional-charge").attr("data-key", key);
                });

                $("#update-additional-charge").on("submit", function(e) {
                    e.preventDefault();
                    loader.show();
                    var file_data = $('#popup_verification_doc')[0].files;
                    var form_data = new FormData(this); // All form data
                    var key = $(this).attr("data-key");
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            loader.hide();
                            Toast.fire({
                                icon: result.status,
                                title: result.message
                            });
                            if (result.status == 'success') {
                                admin_role[key] = result.data;
                                if (result.data.from_date && result.data.to_date) {
                                    new_date = moment(result.data.from_date).format('DD-MM-YYYY') +
                                        ' - ' + moment(result.data.to_date).format('DD-MM-YYYY');
                                    $(".date-" + result.data.id).html(new_date);
                                }
                                $("#edit-admin-role").modal("hide");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-admin-layout>

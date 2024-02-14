<x-admin-layout>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Office Onboarding') }}</li>
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
                {{ __('Edit Office Onboarding') }}
            </x-slot>

            <form method="POST"
                action="{{ route('manage.officeonboardings.edit', ['officeonboarding' => $officeonboarding->id]) }}"
                id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="fk_department_id">Department <span class="text-danger">*</span></x-label>
                                <select name="fk_department_id" id="fk_department_id" class="form-control"
                                    data-placeholder="Select Role">
                                    <option value="">Select Department</option>
                                    @if ($departments)
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('fk_department_id', $officeonboarding->fk_department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->title_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="fk_department_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="fk_office_id">Office <span class="text-danger">*</span></x-label>
                                <select name="fk_office_id" id="fk_office_id" class="form-control"
                                    data-placeholder="Select Office">
                                    @if ($offices && $officeonboarding->fk_department_id)
                                        @foreach ($offices as $office)
                                            @if ($office->fk_department_id == old('fk_department_id', $officeonboarding->fk_department_id))
                                                <option value="{{ $office->id }}"
                                                    {{ old('fk_office_id', $officeonboarding->fk_office_id) == $office->id ? 'selected' : '' }}>
                                                    {{ $office->title_en }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="fk_office_id" />
                            </div>
                        </div>
                        <fieldset class="col-md-12" style="border: solid; 1px;">
                            <legend>Nodal Details</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="nodal_name">Name <span class="text-danger">*</span></x-label>
                                        <input type="text" name="nodal_name" class="form-control" id="nodal_name"
                                            placeholder="Enter Nodal Name"
                                            value="{{ old('nodal_name', $officeonboarding->nodal_name) }}"
                                            style="width: 100%;" />
                                        <x-input-error name="nodal_name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="nodal_email">Email (Accepts only gov.in or nic.in) <span
                                                class="text-danger">*</span></x-label>
                                        <input type="text" name="nodal_email" class="form-control" id="nodal_email"
                                            placeholder="Enter Nodal Email"
                                            value="{{ old('nodal_email', $officeonboarding->nodal_email) }}"
                                            style="width: 100%;" />
                                        <x-input-error name="nodal_email" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="nodal_contact_number">Contact Number <span
                                                class="text-danger">*</span></x-label>
                                        <input type="text" name="nodal_contact_number" class="form-control"
                                            id="nodal_contact_number" placeholder="Enter Nodal Contact Number"
                                            value="{{ old('nodal_contact_number', $officeonboarding->nodal_contact_number) }}"
                                            style="width: 100%;" />
                                        <x-input-error name="nodal_contact_number" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="office_address">Office Address <span
                                                class="text-danger">*</span></x-label>
                                        <input type="text" name="office_address" class="form-control"
                                            id="office_address" placeholder="Enter Nodal Office Address"
                                            value="{{ old('office_address', $officeonboarding->office_address) }}"
                                            style="width: 100%;" />
                                        <x-input-error name="office_address" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="$officeonboarding->status" />
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
                        'update_back' => route('manage.officeonboardings.edit', $officeonboarding->id),
                        'clear' => true,
                        'back' => route('manage.officeonboardings.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                jQuery.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-z\s]+$/i.test(value);
                }, "Only alphabetical characters");

                jQuery.validator.addMethod("validaddress", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9-,\/\s]*$/.test(value);
                }, "Please enter character,number and space only.");

                jQuery.validator.addMethod("email", function(value, element) {
                    return this.optional(element) ||
                        /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
                }, "Please enter Vaild Email.");
                jQuery.validator.addMethod("emailvalid", function(value, element) {
                    if (value.indexOf("gov.in", value.length - "gov.in".length) !== -1) {
                        return true;
                    } else if (value.indexOf("nic.in", value.length - "nic.in".length) !== -1) {
                        return true;
                    } else {
                        return false;
                    }
                }, "Email Should Contains only gov.in or nic.in.");

                var validator = jQuery("#quickForm").validate({
                    rules: {
                        fk_department_id: {
                            required: true,
                        },
                        nodal_name: {
                            required: true,
                            lettersonly: true,
                        },
                        nodal_contact_number: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                        },
                        fk_office_id: {
                            required: true,
                        },
                        nodal_email: {
                            required: true,
                            maxlength: 60,
                            email: true,
                            emailvalid: true
                        },
                        office_address: {
                            required: true,
                            validaddress: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        fk_department_id: {
                            required: 'Department is required.',
                        },
                        nodal_name: {
                            required: 'Nodal Name is required.',
                        },
                        nodal_contact_number: {
                            required: 'Nodal Contact Number is required.',
                        },
                        fk_office_id: {
                            required: 'office is required.',
                        },
                        nodal_email: {
                            required: 'Nodal Email is required.'
                        },
                        office_address: {
                            required: 'Office Address is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    // errorPlacement: function(error, element) {
                    //     if (element.attr("name") == "fk_department_id") {
                    //         error.insertAfter("#department_input");
                    //     } else if(element.attr("name") == "fk_office_id") {
                    //         error.insertAfter("#office_input");
                    //     } else {
                    //         error.insertAfter(element);
                    //     }
                    // },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });

                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
                $('.office_select2').select2({
                    theme: 'bootstrap4'
                });
                const offices = JSON.parse('<?php echo $offices->toJson(); ?>');
                $("#fk_department_id").on("change", function() {
                    let value = $(this).val();
                    let office_options = '<option value="">Select Office</option>';
                    offices.forEach(office => {
                        if (office.fk_department_id == value) {
                            office_options +=
                                `<option value="${office.id}">${office.title_en}</option>`;
                        }
                    });
                    $("#fk_office_id").html(office_options);
                    // $(".office_select2").trigger('change');
                    // validator.form();
                    // $('#fk_department_id').valid();
                });
                // $("#fk_office_id").on("change", function() {
                //     validator.form();
                // });
            });
        </script>
    @endpush
</x-admin-layout>

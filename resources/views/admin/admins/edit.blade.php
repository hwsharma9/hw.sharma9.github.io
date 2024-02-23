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
                            <li class="breadcrumb-item active">{{ __('Admin') }}</li>
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
                {{ __('EDIT ADMIN') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.admins.edit', ['admin' => encrypt($admin->id)]) }}"
                id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="first_name">First Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name', $admin->first_name) }}"
                                    style="width: 100%;" />
                                <x-input-error name="first_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="last_name">Last Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name', $admin->last_name) }}"
                                    style="width: 100%;" />
                                <x-input-error name="last_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="email">Email (Accepts only gov.in or nic.in) <span
                                        class="text-danger">*</span></x-label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Enter Email" value="{{ old('email', $admin->email) }}"
                                    style="width: 100%;" />
                                <x-input-error name="email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="mobile">Mobile Number <span class="text-danger">*</span></x-label>
                                <input type="text" name="mobile" class="form-control" id="mobile"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile', $admin->mobile) }}"
                                    style="width: 100%;" />
                                <x-input-error name="mobile" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="old('status', $admin->status)" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="fk_designation_id">Designation <span
                                        class="text-danger">*</span></x-label>
                                {{-- <input type="text" name="fk_designation_id" class="form-control" id="designation" placeholder="Enter Designation" value="{{old('designation', $admin->designation)}}" style="width: 100%;" /> --}}
                                <select name="fk_designation_id" id="fk_designation_id" class="form-control">
                                    <option value="">Select Designation</option>
                                    @if (old('fk_designation_id', $admin->fk_designation_id))
                                        @foreach ($designations as $designation)
                                            @if (in_array(old('fk_role_id', $designation->fk_role_id), old('role_id', $admin->roles->pluck('id')->all())))
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation', $admin->fk_designation_id) == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="designation" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="role_id">Role <span class="text-danger">*</span></x-label>
                                <select name="role_id[]" id="role_id" class="form-control"
                                    data-placeholder="Select Role">
                                    @foreach ($roles as $role)
                                        @if (in_array($role->id, $admin->roles->pluck('id')->all()))
                                            <option value="{{ $role->id }}"
                                                @if (in_array($role->id, $admin->roles->pluck('id')->all())) selected @endif>{{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error name="role_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="form-group {{ !is_null(old('fk_office_onboarding_id', $admin->detail->fk_office_onboarding_id)) ? '' : 'd-none' }}">
                                <x-label for="fk_office_onboarding_id">Office <span
                                        class="text-danger">*</span></x-label>
                                <select name="fk_office_onboarding_id" id="fk_office_onboarding_id" class="form-control"
                                    data-placeholder="Select Office">
                                    <option value="">Select Office</option>
                                    @if ($office_onboardings)
                                        @foreach ($office_onboardings as $office_onboarding)
                                            <option value="{{ $office_onboarding->id }}"
                                                {{ old('fk_office_onboarding_id', $admin->detail->fk_office_onboarding_id) == $office_onboarding->id ? 'selected' : '' }}>
                                                {{ $office_onboarding->office->title_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="fk_office_onboarding_id" />
                            </div>
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
                        'update_back' => route('manage.admins.edit', $admin->id),
                        'clear' => true,
                        'back' => route('manage.admins.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            jQuery(function() {
                //Initialize Select2 Elements
                $('.role_select2').select2({
                    theme: 'bootstrap4'
                });
                $('.office_onboarding_select2').select2({
                    theme: 'bootstrap4'
                });

                jQuery.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-z\s]+$/i.test(value);
                }, "Only alphabetical characters");

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

                jQuery("#quickForm").validate({
                    rules: {
                        "role_id[]": "required",
                        first_name: {
                            required: true,
                            maxlength: 30,
                            lettersonly: true
                        },
                        last_name: {
                            required: true,
                            maxlength: 30,
                            lettersonly: true
                        },
                        email: {
                            required: true,
                            maxlength: 60,
                            email: true,
                            emailvalid: true
                        },
                        mobile: {
                            required: true,
                        },
                        fk_designation_id: {
                            required: true,
                        },
                        // fk_office_onboarding_id: {
                        //     required: true,
                        // },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        "role_id[]": "Role is Required",
                        first_name: {
                            required: "First Name is Required"
                        },
                        last_name: {
                            required: "Last Name is Required"
                        },
                        mobile: {
                            required: "Mobile Number is Required",
                            minlength: 10,
                            maxlength: 10,
                        },
                        email: {
                            required: "Email is Required"
                        },
                        fk_designation_id: {
                            required: "Designation is Required"
                        },
                        fk_office_onboarding_id: {
                            required: "Office is Required"
                        },
                        captcha: {
                            required: 'Security Code is required.'
                        },
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });

                const designations = JSON.parse('<?php echo $designations->toJson(); ?>');
                $("#role_id").on("change", function() {
                    const value = $(this).val();
                    if (value == 3) {
                        $("#fk_office_onboarding_id").closest('.form-group').removeClass('d-none');
                        $('#fk_office_onboarding_id').rules('add', {
                            'required': true
                        });
                    } else {
                        $("#fk_office_onboarding_id").closest('.form-group').addClass('d-none');
                        $('#fk_office_onboarding_id').rules('remove', 'required');
                    }
                    let designation_options = '<option value="">Select Designation</option>';
                    designations.forEach(designation => {
                        if (designation.fk_role_id == value) {
                            designation_options +=
                                `<option value="${designation.id}">${designation.name}</option>`;
                        }
                    });
                    $("#fk_designation_id").html(designation_options);
                });
            });
        </script>
    @endpush
</x-admin-layout>

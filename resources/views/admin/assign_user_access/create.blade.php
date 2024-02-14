<x-admin-layout>

    @push('styles')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('User Access List') }}</li>
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
                {{ __('ADD USER ACCESS LIST') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.acl.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group">
                                <x-label for="fk_role_id">Role <span class="text-danger">*</span></x-label>
                                <div class="select2-purple" id="role_input">
                                    <select name="fk_role_id" id="fk_role_id" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('fk_role_id') && old('fk_role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error name="fk_role_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="fk_controller_id">Controller <span class="text-danger">*</span></x-label>
                                <div class="select2-purple" id="controller_input">
                                    <select name="fk_controller_id" id="fk_controller_id" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select Controller</option>
                                        @foreach ($controllers as $controller)
                                            <option value="{{ $controller->id }}"
                                                {{ old('fk_controller_id') && old('fk_controller_id') == $controller->id ? 'selected' : '' }}>
                                                {{ $controller->title . ' (' . $controller->controller_name . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error name="fk_controller_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="function_name">Function List <span class="text-danger">*</span></x-label>
                                <div class="form-control function_name">
                                    @if (old('fk_controller_id') && old('function_name'))
                                        @php
                                            $selected_controller = $controllers->where('id', old('fk_controller_id'))->first();
                                            $function_values = array_values(old('function_name'));
                                        @endphp
                                        @if ($selected_controller)
                                            @foreach ($selected_controller->dbControllerRoute as $dbControllerRoute)
                                                <span>
                                                    <input type="checkbox" name="function_name[]"
                                                        value="{{ $dbControllerRoute->permission->id }}"
                                                        {{ in_array($dbControllerRoute->permission->id, $function_values) ? 'checked' : '' }}>
                                                    {{ $dbControllerRoute->function_name }}
                                                    <span>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                                <x-input-error name="function_name" />
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.admins.create'),
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
        <script type="text/javascript">
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                })
            });
            const controllers = JSON.parse('<?php echo json_encode($controllers); ?>');

            jQuery(function() {

                jQuery("#quickForm1").validate({
                    rules: {
                        fk_role_id: {
                            required: true,
                        },
                        fk_controller_id: {
                            required: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        fk_role_id: {
                            required: "Role Name is required field!"
                        },
                        fk_controller_id: {
                            required: "Controller is required field!"
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "fk_role_id") {
                            error.insertAfter("#role_input");
                        } else if (element.attr("name") == "fk_controller_id") {
                            error.insertAfter("#controller_input");
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });
            });

            $("#fk_controller_id").on("change", function() {
                const value = $(this).val();
                const found = controllers.find(controller => controller.id == value);
                // console.log(value);
                // console.log(found.db_controller_route);
                let checkbox_html = '';
                found.db_controller_route.forEach(route => {
                    checkbox_html +=
                        `<span><input type="checkbox" name="function_name[]" value="${route.permission.id}">${route.function_name}<span>`;
                })
                $(".function_name").html(checkbox_html);
            });
        </script>
    @endpush
</x-admin-layout>

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
                            <li class="breadcrumb-item active">{{ __('User Access List') }}</li>
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
                {{ __('EDIT USER ACCESS LIST') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.acl.edit', $acl->id) }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group">
                                <x-label for="fk_role_id">Role <span class="text-danger">*</span></x-label>
                                <div class="select2-purple">
                                    <input type="text" value="{{ $acl->role->name }}" class="form-control" disabled>
                                </div>
                                <x-input-error name="fk_role_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="fk_controller_id">Controller <span class="text-danger">*</span></x-label>
                                <input type="text" value="{{ $acl->tblController->controller_name }}"
                                    class="form-control" disabled>
                                <x-input-error name="fk_controller_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="function_name">Function List <span class="text-danger">*</span></x-label>
                                <div class="form-control function_name">
                                    @foreach ($acl->tblController->dbControllerRoute as $dbControllerRoute)
                                        @if (isset($dbControllerRoute->permission))
                                            <span><input type="checkbox" name="function_name[]"
                                                    value="{{ $dbControllerRoute->permission->id }}"
                                                    @if ($dbControllerRoute->permission && in_array($dbControllerRoute->permission->id, $selected_permission)) checked @endif>{{ $dbControllerRoute->function_name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                                <x-input-error name="function_name" />
                            </div>
                            <x-admin.status-dropdown :selected="$acl->status" />
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
                        'update' => true,
                        'update_back' => route('manage.acl.edit', $acl->id),
                        'clear' => true,
                        'back' => route('manage.acl.index'),
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
            jQuery(function() {
                jQuery("#quickForm").validate({
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
        </script>
    @endpush
</x-admin-layout>

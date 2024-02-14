<x-admin-layout>

    @push('styles')
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('User') }}</li>
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
                {{ __('ADD USER') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.users.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="role_id">Role Name <span class="text-danger">*</span></x-label>
                                <select name="role_id" id="role_id" class="form-control" style="width: 100%;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error name="role_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="first_name">First Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name') }}"
                                    style="width: 100%;" />
                                <x-input-error name="first_name" />
                            </div>
                            <div class="form-group">
                                <x-label for="email">Email <span class="text-danger">*</span></x-label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Enter Email" value="{{ old('email') }}" style="width: 100%;" />
                                <x-input-error name="email" />
                            </div>
                            <div class="form-group">
                                <x-label for="mobile">Mobile Number <span class="text-danger">*</span></x-label>
                                <input type="text" name="mobile" class="form-control" id="mobile"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile') }}"
                                    style="width: 100%;" />
                                <x-input-error name="mobile" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="designation">Designation <span class="text-danger">*</span></x-label>
                                <input type="text" name="designation" class="form-control" id="designation"
                                    placeholder="Enter Designation" value="{{ old('designation') }}"
                                    style="width: 100%;" />
                                <x-input-error name="designation" />
                            </div>
                            <div class="form-group">
                                <x-label for="last_name">Last Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name') }}" style="width: 100%;" />
                                <x-input-error name="last_name" />
                            </div>
                            <div class="form-group">
                                <x-label for="designation">Username <span class="text-danger">*</span></x-label>
                                <input type="text" name="username" class="form-control" id="username"
                                    placeholder="Enter Username" value="{{ old('username') }}" style="width: 100%;" />
                                <x-input-error name="username" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.users.create'),
                        'clear' => true,
                        'back' => route('manage.users.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                jQuery.validator.addMethod("alphaspace", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9\s]*$/.test(value);
                }, "Please enter character and space only.");

                jQuery("#quickForm").validate({
                    rules: {
                        username: {
                            required: true,
                            maxlength: 50
                        },
                        first_name: {
                            required: true,
                            maxlength: 50
                        },
                        last_name: {
                            required: true,
                            maxlength: 50
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        mobile: {
                            required: true,
                        },
                        designation: {
                            required: true,
                            maxlength: 350
                        },
                        password: {
                            required: true,
                            maxlength: 10
                        },
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>

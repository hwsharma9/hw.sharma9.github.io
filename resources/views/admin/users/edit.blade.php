<x-admin-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('User') }}</li>
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
                {{ __('EDIT USER') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.users.edit', ['user' => $user->id]) }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="role_id">Role Name <span class="text-danger">*</span></x-label>
                                <select name="role_id" id="role_id" class="form-control" style="width: 100%;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if (in_array($role->id, $user->roles->pluck('id')->all())) selected @endif>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="first_name">First Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name', $user->first_name) }}"
                                    style="width: 100%;" />
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="email">Email <span class="text-danger">*</span></x-label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Enter Email" value="{{ old('email', $user->email) }}"
                                    style="width: 100%;" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="password_resend" style="width: 100%">Resend Password <span
                                        class="text-danger">*</span></x-label>
                                <input type="radio" name="password_resend" value="1">Yes
                                <input type="radio" name="password_resend" value="0" checked>No
                                @error('password_resend')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="designation">Designation <span class="text-danger">*</span></x-label>
                                <input type="text" name="designation" class="form-control" id="designation"
                                    placeholder="Enter Designation"
                                    value="{{ old('designation', $user->designation) }}" style="width: 100%;" />
                                @error('designation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="last_name">Last Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name', $user->last_name) }}"
                                    style="width: 100%;" />
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="mobile">Mobile Number <span class="text-danger">*</span></x-label>
                                <input type="text" name="mobile" class="form-control" id="mobile"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile', $user->mobile) }}"
                                    style="width: 100%;" />
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <x-admin.status-dropdown :selected="$user->status" />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary">Clear</button>
                    <a href="{{ route('manage.roles.index') }}" class="btn btn-info">Back</a>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
</x-admin-layout>

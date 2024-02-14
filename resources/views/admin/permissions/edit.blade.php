<x-admin-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('manage.permissions.index') }}">{{ __('Permission') }}</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
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
                {{ __('ADD PERMISSION') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.permissions.edit', $permission->id) }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="name">Permission Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter Permission Name" value="{{ old('name', $permission->name) }}"
                                    style="width: 100%;" autofocus />
                                <x-input-error name="name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="guard_name">Panel Name <span class="text-danger">*</span></x-label>
                                <select name="guard_name" id="guard_name" class="form-control">
                                    <option value="admin"
                                        {{ old('guard_name', $permission->guard_name) === 'admin' ? 'selected' : '' }}>
                                        admin</option>
                                    <option value="web"
                                        {{ old('guard_name', $permission->guard_name) === 'web' ? 'selected' : '' }}>web
                                    </option>
                                </select>
                                <x-input-error name="guard_name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-label for="fk_controller_route_id">Route <span class="text-danger">*</span></x-label>
                                <select name="fk_controller_route_id" class="form-control">
                                    <option value="">Select Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}"
                                            {{ old('fk_controller_route_id', $permission->fk_controller_route_id) === $route->id ? 'selected' : '' }}>
                                            {{ $route->dbController->controller_name . '->' . $route->function_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error name="fk_controller_route_id" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.permissions.edit', $permission->id),
                        'clear' => true,
                        'back' => route('manage.permissions.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
</x-admin-layout>

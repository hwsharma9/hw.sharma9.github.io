<x-admin-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Database Route') }}</li>
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">{{ __('ADD DATABASE ROUTE') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('manage.databaseroutes.store') }}" id="quickForm">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <x-label for="controller_name">Controller Name <span
                                                        class="text-danger">*</span></x-label>
                                                <input type="text" name="controller_name" class="form-control"
                                                    id="controller_name" placeholder="Enter Controller Name"
                                                    value="{{ old('controller_name') }}" style="width: 100%;" />
                                                <x-input-error name="controller_name" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <x-label for="resides_at">Controller Resides at <span
                                                        class="text-danger">*</span></x-label>
                                                <select name="resides_at" class="form-control">
                                                    <option value="manage"
                                                        @if (old('resides_at') === 'manage') selected @endif>Manage
                                                    </option>
                                                    <option value="user"
                                                        @if (old('resides_at') === 'user') selected @endif>User</option>
                                                    <option value=""
                                                        @if (old('resides_at') === '') selected @endif>Root</option>
                                                </select>
                                                <x-input-error name="resides_at" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary">Clear</button>
                                    <a href="{{ route('manage.databaseroutes.index') }}" class="btn btn-info">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    @push('scripts')
        <script>
            $(".add_html").on("click", function() {
                var html = $(this).closest(".row").clone();
                html.find("input,textarea").val("");
                html.find(".add_html").removeClass("add_html btn-primary").addClass("remove_html btn-danger");
                html.find(".fa-plus").removeClass("fa-plus").addClass("fa-trash").closest(".row");
                $(this).closest(".html_detail").append(html);
            });
            $("body").on("click", ".remove_html", function() {
                $(this).closest(".row").remove();
            });
        </script>
    @endpush
</x-admin-layout>

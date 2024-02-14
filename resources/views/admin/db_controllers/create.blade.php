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
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('ADD DATABASE ROUTE') }}
            </x-slot>
            <form method="POST" action="{{ route('manage.dbcontrollers.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="title">Title <span class="text-danger">*</span></x-label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Enter Title" value="{{ old('title') }}" style="width: 100%;" />
                                <x-input-error name="title" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="controller_name">Controller <span class="text-danger">*</span></x-label>
                                <input type="text" name="controller_name" class="form-control text-capitalize"
                                    id="controller_name" placeholder="Enter Controller Name"
                                    value="{{ old('controller_name') }}" style="width: 100%;" />
                                <x-input-error name="controller_name" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-label for="resides_at">Controller Location <span
                                        class="text-danger">*</span></x-label>
                                <select name="resides_at" class="form-control">
                                    @if (config('constents.resides_at'))
                                        @foreach (config('constents.resides_at') as $resides_at)
                                            <option value="{{ $resides_at }}"
                                                @if (old('resides_at') === $resides_at) selected @endif>
                                                {{ ucfirst($resides_at == 'manage' ? 'admin' : $resides_at) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error name="resides_at" />
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="html_detail mt-3">
                        @if (old('function_name'))
                            @foreach (old('function_name') as $key => $item)
                                <div class="row">
                                    <div class="col-3 form-group">
                                        <x-label for="method">Function Name</x-label>
                                        <input type="text" class="form-control" name="function_name[]"
                                            value="{{ old('function_name')[$key] }}" placeholder="Function Name">
                                        @if ($errors->has('function_name.' . $key))
                                            <span
                                                class="text-danger">{{ $errors->first('function_name.' . $key) }}</span>
                                        @enderror
                                </div>
                                <div class="col-2 form-group">
                                    <x-label for="method">Method</x-label>
                                    <select name="method[]" class="form-control">
                                        @if (config('constents.controller_methods'))
                                            @foreach (config('constents.controller_methods') as $method)
                                                <option value="{{ $method }}">{{ $method }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-3 form-group">
                                    <x-label for="route">URL</x-label>
                                    <input type="text" class="form-control" name="route[]"
                                        value="{{ old('route')[$key] }}" placeholder="URL">
                                    @if ($errors->has('route.' . $key))
                                        <span class="text-danger">{{ $errors->first('route.' . $key) }}</span>
                                    @enderror
                            </div>
                            <div class="col-3 form-group">
                                <x-label for="named_route">Route</x-label>
                                <input type="text" class="form-control" name="named_route[]"
                                    value="{{ old('named_route')[$key] }}" placeholder="Named Route">
                                @if ($errors->has('named_route.' . $key))
                                    <span
                                        class="text-danger">{{ $errors->first('named_route.' . $key) }}</span>
                                @enderror
                        </div>
                        <div class="col-1 form-group">
                            @if ($loop->first)
                                <button type="button"
                                    class="btn btn-primary btn-icon-anim btn-square add_html"><i
                                        class="fa fa-plus"></i>
                                </button>
                            @else
                                <button type="button"
                                    class="btn btn-danger btn-icon-anim btn-square remove_html"><i
                                        class="fa fa-trash"></i>
                                </button>
                            @endif
                        </div>
                        <div class="clearfix">&nbsp;</div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-3 form-group">
                        <x-label for="method">Function Name</x-label>
                        <input type="text" class="form-control" name="function_name[]" value=""
                            placeholder="Function Name">
                    </div>
                    <div class="col-2 form-group">
                        <x-label for="method">Method</x-label>
                        <select name="method[]" class="form-control">
                            @if (config('constents.controller_methods'))
                                @foreach (config('constents.controller_methods') as $method)
                                    <option value="{{ $method }}">{{ $method }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-3 form-group">
                        <x-label for="route">URL</x-label>
                        <input type="text" class="form-control" name="route[]" value=""
                            placeholder="URL">
                    </div>
                    <div class="col-3 form-group">
                        <x-label for="named_route">Route</x-label>
                        <input type="text" class="form-control" name="named_route[]" value=""
                            placeholder="Named Route">
                    </div>
                    <div class="col-1 form-group">
                        <button type="button"
                            class="btn btn-primary btn-icon-anim btn-square add_html"><i
                                class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </div>
            @endif
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <x-admin.form-actions :actions="[
            'create' => true,
            'create_back' => route('manage.dbcontrollers.create'),
            'clear' => true,
            'back' => route('manage.dbcontrollers.index'),
        ]" />
    </div>
</form>
<div id="accordion" style="margin-top: 10px;">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <h2>Note:</h2>
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <h3>Controller</h3>
                <ol>
                    <li>
                        Controller Name do not contains spaces or any special characters.
                    </li>
                    <li>
                        Controller Name should be in PascalCase Ex. SchoolController
                    </li>
                </ol>
                <h3>Function Name</h3>
                <ol>
                    <li>
                        Function Name do not contains spaces or any special characters.
                    </li>
                    <li>
                        Function Name should be in camelCase Ex. createSchool or create.
                    </li>
                </ol>
                <h3>URL</h3>
                <ol>
                    <li>
                        URL contains a-z, A-Z or /.
                    </li>
                    <li>
                        To pass the parameter in url use {}. Ex. edit/{school}
                    </li>
                    <li>
                        If url is already associated with any menu use {__?}.
                        Ex. index/{school?}
                    </li>
                </ol>
                <h3>Route</h3>
                <ol>
                    <li>
                        Route contains a-z, A-Z or . Ex. school.index, school.create, school.edit
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
</x-admin.container-card>
</x-slot>
@push('scripts')
<script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
<script>
    jQuery(function() {
        jQuery("#quickForm").validate({
            rules: {
                title: {
                    required: true,
                },
                resides_at: {
                    required: true,
                },
                controller_name: {
                    required: true,
                },
                'function_name[]': {
                    required: true,
                },
            },
            submitHandler: function(form) {
                loader.show();
                form.submit();
            }
        });
    });
    $(".add_html").on("click", function() {
        var html = $(this).closest(".row").clone();
        html.find("input,textarea").val("");
        html.find(".add_html").removeClass("add_html btn-primary").addClass("remove_html btn-danger");
        html.find(".fa-plus").removeClass("fa-plus").addClass("fa-trash").closest(".row");
        html.find('label.error').remove();
        $(this).closest(".html_detail").append(html);
    });
    $("body").on("click", ".remove_html", function() {
        $(this).closest(".row").remove();
    });

    $("#controller_name").on("blur", function() {
        $(this).val($(this).val().split(" ").map(
            string => {
                string = string.charAt(0).toUpperCase() + string.slice(1);
                return string.trim();
            }).join(""));
    });
</script>
@endpush
</x-admin-layout>

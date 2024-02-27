<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="{{ asset('webroot/plugins/jqtree/jquery.tree.min.css') }}" type="text/css">

        <style>
            .ui-widget-content {
                border: 1px solid #f0f0f0;
                background: #ffffff url(images/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x;
                color: #222222
                /*{fcContent}*/
                ;
                padding: 25px;
            }

            .ui-widget ul {
                padding: 10px 25px
            }
        </style>
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('User Privileges') }}</li>
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
                {{ __('ADD USER PRIVILEGE') }}
            </x-slot>
            <form method="POST" action="{{ route('manage.roles.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <x-label for="name">User Role Name <span class="text-danger">*</span></x-label>
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="Enter Privileg Name" value="{{ old('name') }}" style="width: 100%;" />
                        <x-input-error name="name" />
                    </div>
                    <div class="form-group">
                        <x-label for="description">Role Description <span class="text-danger">*</span></x-label>
                        <textarea class="form-control" name="description" id="description" cols="10" rows="4" style="width: 100%;">{{ old('description') }}</textarea>
                        <x-input-error name="description" />
                    </div>
                    <div class="form-group">
                        <x-label for="previleg">Privilege <span class="text-danger">*</span></x-label>
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                            data-target="#modal-default">
                            Choose Menu Privilege
                        </button>
                        <x-input-error name="range" />
                    </div>
                    <div class="form-group">
                        <x-label for="previleg">Role Used For <span class="text-danger">*</span></x-label>
                        <select name="used_for" id="used_for" class="form-control">
                            <option value="backend" selected>Backend</option>
                            <option value="frontend">Frontend</option>
                        </select>
                        <x-input-error name="used_for" />
                    </div>
                    <x-admin.captcha />
                    {{-- <div class="row mt-4">
                <x-label for="permissions" style="width: 100%">URL Permissions</x-label>
                @foreach ($group_routes as $key => $group_route)
                <div class="col-md-3">
                    <x-label>{{$group_route->title}}</x-label>
                    @if ($group_route->dbControllerRoute)
                    <ol>
                        @foreach ($group_route->dbControllerRoute as $controller_route)
                        @if ($controller_route->permission)
                            <li>
                                <input type="checkbox" name="other_permissions[]"
                                value="{{$controller_route->permission->id}}" /> {{$controller_route->permission->name}}
                            </li>
                            @endif
                        @endforeach
                    </ol>
                    @endif
                </div>
                @endforeach
            </div> --}}
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.roles.create'),
                        'clear' => true,
                        'back' => route('manage.roles.index'),
                    ]" />
                </div>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content bg-default">
                            <div class="modal-header">
                                <h4 class="modal-title">Previlege Menu Tree</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-5 justify-content-between">
                                    <button type="button" class="btn btn-primary active" id="example-5-checkAll">Check
                                        all nodes</button>
                                    <button type="button" class="btn btn-secondary" id="example-5-uncheckAll">Uncheck
                                        all
                                        nodes</button>
                                </div>
                                <div id="tree">
                                    <x-admin.admin-menu-tree-checkbox :menus="$menus" :role="[]" />
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/jqtree/jquery.tree.min.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                jQuery.validator.addMethod("validRoleName", function(value, element) {
                        return this.optional(element) || /^[a-zA-Z0-9-(-)\-\s]*$/.test(value);
                    },
                    "Please Enter Character (a to z or A to Z), Number (0-9), Space, Hyphen (-), Parentheses Left and Parentheses Right Only."
                );
                jQuery("#quickForm").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 50,
                            validRoleName: true
                        },
                        description: {
                            required: true,
                        },
                        captcha: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "Name field is required."
                        },
                        description: {
                            required: "Description field is required."
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
            });
            $(document).ready(function() {
                $('#tree').tree({
                    /* specify here your options */
                });

                $('#example-5-checkAll').click(function() {
                    $('#tree').tree('checkAll');
                });

                $('#example-5-uncheckAll').click(function() {
                    $('#tree').tree('uncheckAll');
                });

                $('#CustLink').click(function(e) {
                    e.preventDefault();
                });

            });
        </script>
    @endpush
</x-admin-layout>

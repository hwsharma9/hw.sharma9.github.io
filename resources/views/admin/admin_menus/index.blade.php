<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/nestable/nestable.css') }}">
    @endpush

    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Create Menu') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
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
                {{ __('Create Menu') }}
            </x-slot>
            <input type="hidden" id="nestable-output">
            <form action="{{ route('manage.menus.create') }}" method="POST" id="frmMenu">
                <input type="hidden" id="id" name="id" value="" />
                @csrf
                <!-- /.card-header -->
                <div class="card-body" id="create-menu">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label>Menu Name</x-label>
                                <input type="text" name="menu_name" id="menu_name" class="form-control"
                                    placeholder="Enter Menu Name" style="width: 100%;" value="{{ old('menu_name') }}" />
                                @error('menu_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label>Controller Name</x-label>
                                <select name="fk_tbl_acl_permission_id" id="fk_tbl_acl_permission_id"
                                    class="form-control select2" placeholder="Enter Icon class Name"
                                    style="width: 100%;">
                                    <option value="">Select Permission</option>
                                    @foreach ($db_controller as $db_controller)
                                        @foreach ($db_controller->dbControllerRoute as $dbControllerRoute)
                                            <option value="{{ $dbControllerRoute->permission->id }}"
                                                data-route="{{ $dbControllerRoute->route }}">
                                                {{ $db_controller->title }} ({{ $db_controller->controller_name }})
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('fk_tbl_acl_permission_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label>Icon class Name</x-label>
                                <select name="icon_class" id="icon_class" class="form-control">
                                    <option value="fa fa-hand-point-right">fa fa-hand-point-right</option>
                                    <option value="fas fa-folder-open">fas fa-folder-open</option>
                                </select>
                                @error('icon_class')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                    <div class="form-group">
                        <x-label>Minimal</x-label>
                        <select class="form-control select2" style="width: 100%;">
                            <option selected="selected">Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                </div> --}}
                    </div>
                    <div class="row" id="params"></div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    <button type="button" id="reset" class="btn btn-secondary"
                        data-action="{{ route('manage.menus.create') }}">New</button>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-12">
                    <menu id="nestable-menu">
                        <button class="btn btn-danger" type="button" data-action="expand-all"><i
                                class="fa fa-plus-circle"></i> Expand All</button>
                        <button class="btn btn-warning" type="button" data-action="collapse-all"><i
                                class="fa fa-minus-circle"></i> Collapse All</button>
                    </menu>
                </div>
                <!--End column-->
            </div>
            <!--End row-->
            <div class="cf nestable-items">
                <div class="dd" id="nestable">
                    <x-admin.admin-menu-tree :menus="$menus" class="dd-list" />
                </div>
            </div>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {

                jQuery("#frmMenu").validate({
                    rules: {
                        menu_name: {
                            required: true,
                            minlength: 2,
                            maxlength: 40
                        },
                        icon_class: {
                            required: true,
                        },
                        // fk_tbl_acl_permission_id: {
                        //     required: true,
                        // },
                    },
                    messages: {
                        menu_name: {
                            required: "Menu name is required field!"
                        },
                        icon_class: {
                            required: "Icon name is required field!"
                        },
                        // fk_tbl_acl_permission_id: {
                        //     required: "Permission is required field!"
                        // },
                    }
                });
            });
        </script>
        <script src="{{ asset('webroot/plugins/nestable/jquery.nestable.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                })
            });
            $(document).ready(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });
                var updateOutput = function(e) {
                    var list = e.length ? e : $(e.target),
                        output = list.data('output');
                    if (window.JSON) {
                        output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                    } else {
                        output.val('JSON browser support required for this demo.');
                    }
                };
                // activate Nestable for list 1
                $('#nestable').nestable({
                        group: 1
                    })
                    .on('change', updateOutput);

                // output initial serialised data
                updateOutput($('#nestable').data('output', $('#nestable-output')));

                $('#nestable-menu').on('click', function(e) {
                    var target = $(e.target),
                        action = target.data('action');
                    if (action === 'expand-all') {
                        $('.dd').nestable('expandAll');
                    }
                    if (action === 'collapse-all') {
                        $('.dd').nestable('collapseAll');
                    }
                });

                $("#submit").click(function(e) {
                    e.preventDefault();
                    if (jQuery("#frmMenu").valid() == true) {
                        var id = parseInt($("#id").val());
                        id = (isNaN(id)) ? 0 : id;
                        let params = $(".params").val();

                        $(".form-group .text-danger").html("");

                        // var dataString = {
                        //     'menu_name': $("#menu_name").val(),
                        //     'icon_class': $("#icon_class").val(),
                        //     'fk_tbl_acl_permission_id': $("#fk_tbl_acl_permission_id").val().trigger('change'),
                        //     'id': id
                        // };
                        var dataString = $(document).find("#frmMenu").serializeArray();
                        $.ajax({
                            type: "POST",
                            url: jQuery("#frmMenu").attr('action'),
                            data: dataString,
                            dataType: "json",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (!data.hasOwnProperty('errors')) {
                                    console.log('update', JSON.stringify(data.data));
                                    $("#label_show-" + data.data.id).text(data.data.menu_name);
                                    $("#menu-" + data.data.id).attr('data-menu', JSON.stringify(data
                                        .data));
                                    $("#nestable").html(data.html);

                                    $('#menu_name').val('');
                                    $('#id').val('');
                                    $("#icon_class").val('');
                                    $("#parent_id").val('');
                                    $("#fk_tbl_acl_permission_id").val('').trigger('change');
                                    $("#submit").text('Submit');
                                    jQuery("#frmMenu").attr('action', $("#reset").attr(
                                        'data-action'));
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });

                                    for (const property in data.errors) {
                                        $(`#${property}`).closest('.form-group').find(
                                            "span.text-danger").remove();
                                    }
                                } else {
                                    for (const property in data.errors) {
                                        let id = property.replace(/[.]/g, '-');
                                        $(document).find(`#${id}`).closest('.form-group').find(
                                            "span.text-danger").remove();
                                        $(document).find(`#${id}`).closest('.form-group').append(
                                            `<span class="text-danger">${data.errors[property][0]}</span>`
                                        );
                                    }
                                }
                            },
                            error: function(errors) {
                                for (const property in errors) {
                                    $(`#${property}`).closest('.form-group').find(
                                            "span.text-danger")
                                        .remove();
                                    $(`#${property}`).closest('.form-group').append(
                                        `<span class="text-danger">${errors[property][0]}</span>`
                                    );
                                }
                            }
                        });
                    }
                });

                $(document).on("click", ".del-button", function() {
                    var x = confirm('Delete this menu?');
                    var id = $(this).attr('id');
                    if (x) {
                        $.ajax({
                            type: "POST",
                            url: 'menus/' + id,
                            dataType: "json",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.status == true) {
                                    $("li[data-id='" + id + "']").remove();

                                    $('#menu_name').val('');
                                    $('#id').val('');
                                    $("#icon_class").val('');
                                    $("#parent_id").val('');
                                    $("#fk_tbl_acl_permission_id").val('').trigger('change');
                                    $("#submit").text('Submit');
                                    jQuery("#frmMenu").attr('action', $("#reset").attr(
                                        'data-action'));
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                });

                $('.dd').on('change', function() {

                    var dataString = {
                        data: $("#nestable-output").val(),
                    };

                    $.ajax({
                        type: "PATCH",
                        url: '{{ route('manage.menus.update-all') }}',
                        data: dataString,
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        },
                        error: function(xhr, status, error) {}
                    });
                });

                $(document).on("click", ".edit-button", function() {
                    var menu = JSON.parse($(this).attr('data-menu'));
                    // console.log(menu);
                    if (menu.params) {
                        if (menu.hasOwnProperty('permission') && menu.permission) {
                            if (menu['permission'].hasOwnProperty('db_controller_route')) {
                                let route = menu['permission']['db_controller_route'].route;
                                let params = JSON.parse(menu.params);
                                route = route.split('/');
                                if (route.length) {
                                    route = route.filter(string => (string[0] == "{" && string[string.length -
                                        1] == "}"));
                                    route = route.map(string => {
                                        let string_name = string.replace(/[{?}]/g, '');
                                        let value = params[string_name] == undefined ? '' : params[
                                            string_name];
                                        return `<div class="col-md-${12/route.length}">
                                        <div class="form-group">
                                            <x-label class="text-capitalize">${string_name}</x-label>
                                            <input type="text" name="params[${string_name}]" id="params-${string_name}" class="form-control params"
                                            placeholder="Enter ${string_name}" style="width: 100%;" value="${value}" />
                                        </div>
                                    </div>`;
                                    });
                                    $("#params").html(route.join(""));
                                }
                            }
                        }
                    } else {
                        $("#params").html("");
                    }
                    // console.log(menu.permission);
                    $("#id").val(menu.id);
                    $("#menu_name").val(menu.menu_name);
                    $("#icon_class").val(menu.icon_class);
                    $("#fk_tbl_acl_permission_id").val(menu.fk_tbl_acl_permission_id).trigger('change');
                    $("#submit").text('Update');

                    jQuery("#frmMenu").attr('action', $(this).attr('data-action'));
                });

                $(document).on("click", "#reset", function() {
                    $('#id').val('');
                    $('#menu_name').val('');
                    $("#icon_class").val('');
                    $("#fk_tbl_acl_permission_id").val('').trigger('change');
                    $("#submit").text('Submit');
                    $("#params").html("");
                    $(".form-group label.text-danger").each(function(node) {
                        $(this).remove();
                    });
                    $(".form-group label.error").each(function(node) {
                        $(this).remove();
                    });
                    jQuery("#frmMenu").attr('action', $(this).attr('data-action'));
                });

                $("#fk_tbl_acl_permission_id").on("change", function(e) {
                    let route = $(this).find(':selected').attr('data-route');
                    if (route) {
                        route = route.split('/');
                        if (route.length) {
                            route = route.filter(string => (string[0] == "{" && string[string.length - 1] ==
                                "}"));
                            route = route.map(string => {
                                let string_name = string.replace(/[{?}]/g, '');
                                return `<div class="col-md-${12/route.length}">
                                <div class="form-group">
                                    <x-label class="text-capitalize">${string_name}</x-label>
                                    <input type="text" name="params[${string_name}]" id="params-${string_name}" class="form-control params"
                                    placeholder="Enter ${string_name}" style="width: 100%;" value="" />
                                </div>
                            </div>`;
                            });
                            $("#params").html(route.join(""));
                        }
                    } else {
                        $("#params").html("");
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>

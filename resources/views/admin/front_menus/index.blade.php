<x-admin-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/nestable/nestable.css') }}">
    @endpush

    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __($title) }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            @if (Gate::allows('check-auth', 'manage.frontmenus.create'))
                                <a href="{{ route('manage.frontmenus.create') . '?type_id=' . $type_id . '&type=' . $type }}"
                                    class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __($title . ' List') }}
            </x-slot>
            <div class="card-body">
                <input type="hidden" id="nestable-output">
                <div class="row">
                    <div class="col-sm-12">
                        <menu id="nestable-menu">
                            <button class="btn btn-danger" type="button" data-action="expand-all"><i
                                    class="fa fa-plus-circle"></i> Expand All</button>
                            <button class="btn btn-warning" type="button" data-action="collapse-all"><i
                                    class="fa fa-minus-circle"></i> Collapse All</button>
                        </menu>
                    </div>
                </div>
                <div class="cf nestable-items">
                    <div class="dd" id="nestable">
                        <x-admin.front-menu-tree :menus="$menus" class="dd-list" />
                    </div>
                </div>
            </div>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script src="{{ asset('webroot/plugins/nestable/jquery.nestable.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
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

                $(document).on("click", ".del-button", function() {
                    var confirmation = confirm('Really want to delete this menu?');
                    var id = $(this).attr('id');
                    if (confirmation) {
                        $.ajax({
                            type: "POST",
                            url: $(this).attr('data-delete-route'),
                            dataType: "json",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.status == true) {
                                    $("li[data-id='" + id + "']").remove();

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
                        type: "POST",
                        url: '{{ route('manage.frontmenus.update-all') }}',
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
            });
        </script>
    @endpush
</x-admin-layout>

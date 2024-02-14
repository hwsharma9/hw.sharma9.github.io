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
                            <li class="breadcrumb-item active">{{ __('Front Menu') }}</li>
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
                {{ __('Add Front Menu') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.frontmenus.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="fk_menu_type_id">Menu Location <span
                                        class="text-danger">*</span></x-label>
                                <div class="select2-purple">
                                    <select name="fk_menu_type_id" class="form-control">
                                        @if ($front_menu_types)
                                            @foreach ($front_menu_types as $id => $title)
                                                @if ($id == request()->get('type_id'))
                                                    <option value="{{ $id }}">{{ $title }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <x-input-error name="fk_menu_type_id" />
                            </div>
                            <div class="form-group" id="page_module">
                                @if (old('menu_type'))
                                    @if (old('menu_type') == 1)
                                        <x-label for="fk_page_id">Page <span class="text-danger">*</span></x-label>
                                        <div class="select2-purple">
                                            <select name="fk_page_id" class="form-control">
                                                <option value="">Select Page</option>
                                                @if ($front_menu_types)
                                                    @foreach ($pages as $id => $slug)
                                                        <option value="{{ $id }}"
                                                            {{ old('fk_page_id') == $id ? 'selected' : '' }}>
                                                            {{ $slug }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @elseif(old('menu_type') == 2)
                                        <x-label for="fk_page_id">Module <span class="text-danger">*</span></x-label>
                                        <div class="select2-purple">
                                            <select name="fk_page_id" class="form-control">
                                                <option value="">Select Module</option>
                                                @if ($access_list)
                                                    @foreach ($access_list as $id => $slug)
                                                        <option value="{{ $id }}"
                                                            {{ old('fk_page_id') == $id ? 'selected' : '' }}>
                                                            {{ $slug }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @elseif(old('menu_type') == 3)
                                        <x-label for="fk_page_id">Custom URL <span
                                                class="text-danger">*</span></x-label>
                                        <div class="select2-purple">
                                            <input type="text" name="fk_page_id" placeholder="Enter the Current URL"
                                                class="form-control" value="{{ old('fk_page_id') }}" />
                                        </div>
                                    @else
                                        <x-label for="fk_page_id">Hash <span class="text-danger">*</span></x-label>
                                        <div class="select2-purple">
                                            <input type="text" name="fk_page_id" placeholder="Enter the Current URL"
                                                class="form-control" value="#" readonly />
                                        </div>
                                    @endif
                                @else
                                    <x-label for="fk_page_id">Page <span class="text-danger">*</span></x-label>
                                    <div class="select2-purple">
                                        <select name="fk_page_id" class="form-control">
                                            <option value="">Select Page</option>
                                            @if ($front_menu_types)
                                                @foreach ($pages as $id => $slug)
                                                    <option value="{{ $id }}">{{ $slug }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @endif
                                <x-input-error name="fk_page_id" />
                            </div>
                            <div class="form-group">
                                <x-label for="title_hi">Title Hindi <span class="text-danger">*</span></x-label>
                                <div class="select2-purple">
                                    <input type="text" name="title_hi" class="form-control" id="title_hi"
                                        placeholder="Enter Title in Hindi" value="{{ old('title_hi') }}"
                                        style="width: 100%;" />
                                </div>
                                <x-input-error name="title_hi" />
                            </div>
                            <div class="form-group">
                                <x-label for="open_same_tab">URL Open In <span class="text-danger">*</span></x-label>
                                <select name="open_same_tab" id="open_same_tab" class="form-control">
                                    <option value="0">Same Tab</option>
                                    <option value="1">New Tab</option>
                                </select>
                                <x-input-error name="open_same_tab" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="menu_type">Menu Type <span class="text-danger">*</span></x-label>
                                <select name="menu_type" id="menu_type" class="form-control">
                                    <option value="1" {{ old('menu_type') == 1 ? 'selected' : '' }}>Page</option>
                                    <option value="2" {{ old('menu_type') == 2 ? 'selected' : '' }}>Module
                                    </option>
                                    <option value="3" {{ old('menu_type') == 3 ? 'selected' : '' }}>Custom URL
                                    </option>
                                    <option value="4" {{ old('menu_type') == 4 ? 'selected' : '' }}>Hash</option>
                                </select>
                                <x-input-error name="menu_type" />
                            </div>
                            <div class="form-group">
                                <x-label for="icon_class">Menu Icon</x-label>
                                <div class="select2-purple">
                                    <input type="text" name="icon_class" class="form-control" id="icon_class"
                                        placeholder="Enter Title in English" value="{{ old('icon_class') }}"
                                        style="width: 100%;" />
                                </div>
                                <x-input-error name="icon_class" />
                            </div>
                            <div class="form-group">
                                <x-label for="title_en">Title English <span class="text-danger">*</span></x-label>
                                <div class="select2-purple">
                                    <input type="text" name="title_en" class="form-control" id="title_en"
                                        placeholder="Enter Title in English" value="{{ old('title_en') }}"
                                        style="width: 100%;" />
                                </div>
                                <x-input-error name="title_en" />
                            </div>
                            <x-admin.status-dropdown />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'create' => true,
                        'create_back' => route('manage.frontmenus.create'),
                        'clear' => true,
                        'back' => route('manage.frontmenus.index', ['type' => request()->get('type')]),
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
            jQuery(function() {
                jQuery("#quickForm").validate({
                    rules: {
                        fk_menu_type_id: {
                            required: true
                        },
                        menu_type: {
                            required: true
                        },
                        fk_page_id: {
                            required: true
                        },
                        title_hi: {
                            required: true
                        },
                        title_en: {
                            required: true
                        },
                        open_same_tab: {
                            required: true
                        },
                    },
                    message: {
                        fk_menu_type_id: {
                            required: "Menu location is required!"
                        },
                        menu_type: {
                            required: "Menu type is required!"
                        },
                        fk_page_id: {
                            required: "This Field is required!"
                        },
                        title_hi: {
                            required: "Title in Hindi is required!"
                        },
                        title_en: {
                            required: "Title in English is required!"
                        },
                        open_same_tab: {
                            required: "This Field is required!"
                        },
                    }
                });
            });

            //Initialize Select2 Elements
            $('.select2').select2()
            const dropdown = {
                1: JSON.parse('<?php echo json_encode($pages); ?>'),
                2: JSON.parse('<?php echo json_encode($access_list); ?>')
            };
            $("#menu_type").on("change", function() {
                const value = $(this).val();
                loader.show();
                setTimeout(() => {
                    if (dropdown.hasOwnProperty(value)) {
                        const label = ((value == 1) ? 'Page' : 'Module');
                        let options =
                            `<select name="fk_page_id" class="form-control"><option value="">Select ${label}</option>`;
                        var newOption = [];
                        for (id in dropdown[value]) {
                            options += `<option value="${id}">${dropdown[value][id]}</option>`;
                            newOption.push({
                                id: id,
                                text: dropdown[value][id]
                            });
                        }
                        options += '</select>';
                        $("#page_module label").html(label + ' <span class="text-danger">*</span>');
                        $("#page_module .select2-purple").html(options);
                        console.log(newOption);
                        $(".select2").select2({
                            data: newOption
                        });
                    } else if (value == 3) {
                        const label = 'Custom URL';
                        $("#page_module label").html(label + ' <span class="text-danger">*</span>');
                        let input =
                            `<input type="text" name="fk_page_id" placeholder="Enter the ${label}" class="form-control" />`
                        $("#page_module .select2-purple").html(input);
                    } else {
                        const label = 'Hash';
                        $("#page_module label").html(label + ' <span class="text-danger">*</span>');
                        let input =
                            `<input type="text" name="fk_page_id" value="#" readonly class="form-control" />`
                        $("#page_module .select2-purple").html(input);
                    }
                    $(".select2").trigger('change');
                    loader.hide();
                }, 500);
            });
        </script>
    @endpush
</x-admin-layout>

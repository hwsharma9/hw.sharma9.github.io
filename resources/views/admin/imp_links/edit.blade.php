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
                            <li class="breadcrumb-item active">{{ __('Important Link') }}</li>
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
                {{ __('EDIT Important Link') }}
            </x-slot>
            <form method="POST" action="{{ route('manage.implinks.edit', ['implink' => $implink->id]) }}"
                id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Title (Hindi) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_hi" class="form-control" id="title_hi"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_hi', $implink->title_hi) }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_hi" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_en">Title (English) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_en" class="form-control" id="title_en"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_en', $implink->title_en) }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_en" />
                            </div>
                        </div>
                    </div>
                    <x-admin.linkable selected-menutype="{{ $implink->menu_type }}"
                        selected-customurl="{{ $implink->custom_url }}"
                        selected-route="{{ $implink->fk_controller_route_id }}"
                        selected-page="{{ $implink->fk_page_id }}" />
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="old('status', $implink->status)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.admins.edit', $implink->id),
                        'clear' => true,
                        'back' => route('manage.admins.index'),
                    ]" />
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script>
            jQuery(function() {
                jQuery("#quickForm").validate({
                    rules: {
                        title_hi: {
                            required: true,
                            minlength: 2,
                            maxlength: 255
                        },
                        title_en: {
                            required: true,
                            minlength: 2,
                            maxlength: 255
                        },
                        status: {
                            required: true,
                            digits: true
                        },
                        captcha: {
                            required: true
                        }
                    },
                    messages: {},
                });
            });
        </script>
    @endpush
</x-admin-layout>

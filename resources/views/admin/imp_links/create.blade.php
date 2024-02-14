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
                            <li class="breadcrumb-item active">{{ __('Important Links') }}</li>
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
                {{ __('ADD Important Links') }}
            </x-slot>
            {{-- <x-auth-validation-errors /> --}}
            <form method="POST" action="{{ route('manage.implinks.create') }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Title (Hindi) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_hi" class="form-control" id="title_hi"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_hi') }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_hi" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_en">Title (English) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_en" class="form-control" id="title_en"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_en') }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_en" />
                            </div>
                        </div>
                    </div>
                    <x-admin.linkable />
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown />
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
                        'create' => true,
                        'create_back' => route('manage.implinks.create'),
                        'clear' => true,
                        'back' => route('manage.implinks.index'),
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
                jQuery.validator.addMethod("alphabates", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
                }, "Please enter character and space only.");

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

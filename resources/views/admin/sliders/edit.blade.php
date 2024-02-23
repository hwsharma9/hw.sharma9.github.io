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
                            <li class="breadcrumb-item active">
                                {{ __($slider_categories[$slider->fk_slider_category_id]) }}</li>
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
                {{ __('EDIT ' . $slider_categories[$slider->fk_slider_category_id]) }}
            </x-slot>
            @php
                $image_hi = isset($uploads['attachment_hindi']) ? asset(Storage::url($uploads['attachment_hindi'])) : asset('dist/img/no-image.png');
                $image_en = isset($uploads['attachment_english']) ? asset(Storage::url($uploads['attachment_english'])) : asset('dist/img/no-image.png');
            @endphp
            <form method="POST" action="{{ route('manage.sliders.edit', ['slider' => $slider->id]) }}"
                enctype="multipart/form-data" id="quickForm">
                @csrf
                <input type="hidden" name="type" value="{{ $slider_categories[$slider->fk_slider_category_id] }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Title (Hindi) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_hi" class="form-control" id="title_hi"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_hi', $slider->title_hi) }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_hi" />
                            </div>
                            <div class="form-group">
                                <x-label for="attachment_hindi">Attachment For Hindi <span
                                        class="text-danger">*</span></x-label>
                                <div class="form-control">
                                    <input type="file" name="attachment_hindi" style="width: 100%;"
                                        id="attachment_hindi" />
                                </div>
                                <small>Only support jpg and png format and size 500KB (width=1920px,
                                    height=328px)</small>
                                <x-input-error name="attachment_hindi" />
                            </div>
                            <div class="form-group">
                                <x-label>View Hindi Image</x-label>
                                <div class="col-sm-12 col-md-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail"
                                            style="max-width: 200px; max-height: 150px;">
                                            <img src="{{ $image_hi }}" alt="Gallery Image"
                                                class="post_images_attachment_hindi" width="200" height="100"
                                                title="Gallery Image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_en">Title (English) <span class="text-danger">*</span></x-label>
                                <input type="text" name="title_en" class="form-control" id="title_en"
                                    placeholder="Enter Title in Hindi" value="{{ old('title_en', $slider->title_en) }}"
                                    style="width: 100%;" />
                                <x-input-error name="title_en" />
                            </div>
                            {{-- <div class="form-group">
                                <x-label for="type">Type <span class="text-danger">*</span></x-label>
                                <input type="text" disabled class="form-control" placeholder="Type" id="type"
                                    value="{{ $slider_categories[$slider->fk_slider_category_id] }}" />
                                <x-input-error name="type" />
                            </div> --}}
                            <div class="form-group">
                                <x-label for="attachment_english">Attachment For English <span
                                        class="text-danger">*</span></x-label>
                                <div class="form-control">
                                    <input type="file" name="attachment_english" style="width: 100%;"
                                        id="attachment_english" />
                                </div>
                                <small>Only support jpg and png format and size 500KB (width=1920px,
                                    height=328px)</small>
                                <x-input-error name="attachment_english" />
                            </div>
                            <div class="form-group">
                                <x-label>View English Image</x-label>
                                <div class="col-sm-12 col-md-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail"
                                            style="max-width: 200px; max-height: 150px;">
                                            <img src="{{ $image_en }}" alt="Gallery Image"
                                                class="post_images_attachment_english" width="200" height="100"
                                                title="Gallery Image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-admin.linkable selected-menutype="{{ $slider->menu_type }}"
                        selected-customurl="{{ $slider->custom_url }}"
                        selected-route="{{ $slider->fk_controller_route_id }}"
                        selected-page="{{ $slider->fk_page_id }}" />
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.status-dropdown :selected="old('status', $slider->status)" />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.sliders.edit', $slider->id),
                        'clear' => true,
                        'back' => route('manage.sliders.index', [
                            'type' => $slider_categories[$slider->fk_slider_category_id],
                        ]),
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

                $("#attachment_hindi, #attachment_english").change(function() {
                    readURL_photo(this);
                });

                function readURL_photo(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var viewClassName = $(input).attr('id');
                            $('.post_images_' + viewClassName).attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                } //end readURL_photo function


                jQuery.validator.addMethod("alphanumspace", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9\s]*$/.test(value);
                }, "Please enter character, number and space only.");

                $.validator.addMethod('filesize', function(value, element, param) {
                    return this.optional(element) || (element.files[0].size <= param)
                }, $.validator.format("Uploaded file size should be less than or equal to 500 KB)."));
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
                        attachment_hindi: {
                            // required: true,
                            extension: 'JPEG|jpeg|JPG|jpg|png',
                            filesize: 512000
                        },
                        attachment_english: {
                            // required: true,
                            extension: 'JPEG|jpeg|JPG|jpg|png',
                            filesize: 512000
                        }
                    },
                    messages: {
                        attachment_hindi: {
                            extension: "Please upload only JPEG,JPG Formet",
                            filesize: "File size must be less than 500 KB"
                        },
                        attachment_english: {
                            extension: "Please upload only JPEG,JPG Formet",
                            filesize: "File size must be less than 500 KB"
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>

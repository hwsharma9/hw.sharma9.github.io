<x-admin-layout>

    @push('styles')
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Page') }}</li>
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
                {{ __('EDIT PAGE') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.pages.edit', ['page' => $page->id]) }}" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="slug">Slug <span class="text-danger">*</span></x-label>
                                <input name="slug" value="{{ old('slug', $page->slug) }}" id="slug"
                                    class="form-control" style="width: 100%;" readonly />
                                <x-input-error name="slug" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_hi">Title Hindi<span class="text-danger">*</span></x-label>
                                <input name="title_hi" value="{{ old('title_hi', $page->title_hi) }}" id="title_hi"
                                    class="form-control" style="width: 100%;" />
                                <x-input-error name="title_hi" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="description_hi">Description Hindi <span
                                        class="text-danger">*</span></x-label>
                                <textarea name="description_hi" id="description_hi" value="{{ old('description_hi', $page->description_hi) }}">{{ old('description_hi', $page->description_hi) }}</textarea>
                                <x-input-error name="description_hi" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="title_en">Title English<span class="text-danger">*</span></x-label>
                                <input name="title_en" value="{{ old('title_en', $page->title_en) }}" id="title_en"
                                    class="form-control" style="width: 100%;" />
                                <x-input-error name="title_en" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="description_en">Description English <span
                                        class="text-danger">*</span></x-label>
                                <textarea name="description_en" id="description_en" value="{{ old('description_en', $page->description_en) }}">{{ old('description_en', $page->description_en) }}</textarea>
                                <x-input-error name="description_en" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <x-admin.status-dropdown :selected='$page->status' />
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="meta_title">SEO Title</x-label>
                                <input type="text" name="meta_title"
                                    value="{{ old('meta_title', $page->meta_title) }}" class="form-control"
                                    id="meta_title" placeholder="Enter Meta Title" style="width: 100%;" />
                                <x-input-error name="meta_title" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="meta_keyword">SEO Keyword (Ex:- MAX 12 KEYWORD)</x-label>
                                <input type="text" name="meta_keyword"
                                    value="{{ old('meta_keyword', $page->meta_keyword) }}" id="meta_keyword"
                                    class="form-control" style="width: 100%;" />
                                <x-input-error name="meta_keyword" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-label for="meta_description">SEO Description</x-label>
                                <textarea name="meta_description" id="meta_description" class="form-control">{{ old('meta_description', $page->meta_description) }}</textarea>
                                <x-input-error name="meta_description" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <x-admin.form-actions :actions="[
                        'update' => true,
                        'update_back' => route('manage.pages.edit', $page->id),
                        'clear' => true,
                        'back' => route('manage.pages.index'),
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
                jQuery.validator.addMethod("alphaspace", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9\s]*$/.test(value);
                }, "Please enter character and space only.");

                jQuery("#quickForm").validate({
                    rules: {
                        username: {
                            required: true,
                            maxlength: 50
                        },
                        first_name: {
                            required: true,
                            maxlength: 50
                        },
                        last_name: {
                            required: true,
                            maxlength: 50
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        mobile: {
                            required: true,
                        },
                        designation: {
                            required: true,
                            maxlength: 350
                        },
                        password: {
                            required: true,
                            maxlength: 10
                        },
                    }
                });
            });
        </script>
        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            //<![CDATA[
            CKEDITOR.replace('description_hi', {
                "toolbar": "Full",
                "language": "en",
                "width": "100%",
                "height": "280px",
                "filebrowserBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html",
                "filebrowserImageBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html?type=Images",
                "filebrowserFlashBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html?type=Flash",
                "filebrowserUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files",
                "filebrowserImageUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images",
                "filebrowserFlashUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash"
            });
            CKEDITOR.replace('description_en', {
                "toolbar": "Full",
                "language": "en",
                "width": "100%",
                "height": "280px",
                "filebrowserBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html",
                "filebrowserImageBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html?type=Images",
                "filebrowserFlashBrowseUrl": "\/wqc_for_live\/webroot\/ckfinder\/ckfinder.html?type=Flash",
                "filebrowserUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files",
                "filebrowserImageUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images",
                "filebrowserFlashUploadUrl": "\/wqc_for_live\/webroot\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash"
            });
            //]]>
        </script>
        <script type="text/javascript">
            $("#title_hi").on("keyup", function(e) {
                console.log(e.target.value);
            })
        </script>
    @endpush
</x-admin-layout>

<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/dropzone/css/dropzone.css') }}">
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Media') }}</li>
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
                {{ __('DROP YOUR IMAGE HERE') }}
            </x-slot>
            <div class="row">
                <div class="col-md-12">
                    <div class="note note-info">
                        <p>Max File Size is 10 Mb and accepted File extension is
                            ".pdf,.doc,.docx,.jpeg,.jpg,.JPG,.JPEG,.png,.pdf,.xls,.xlsx,.mp4"</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('manage.medias.create') }}" id="frmuploadpicture"
                name="frmuploadpicture" enctype="multipart/form-data" class="dropzone">
                @csrf
            </form>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript">
            // Dropzone.autoDiscover = false;
            $(document).ready(function() {
                //File Upload response from the server
                var accept = ".pdf,.doc,.docx,.jpeg,.jpg,.JPG,.JPEG,.png,.pdf,.xls,.xlsx,.mp4";

                Dropzone.options.dropzoneForm = {
                    maxFiles: 5,
                    maxFilesize: 10, //MB
                    acceptedFiles: accept,
                    init: function() {
                        this.on("complete", function(data) {
                            var res = eval('(' + data.xhr.responseText + ')');
                        });

                    }
                };
            });
        </script>
        <script src="{{ asset('webroot/plugins/dropzone/dropzone.min.js') }}"></script>
    @endpush
</x-admin-layout>

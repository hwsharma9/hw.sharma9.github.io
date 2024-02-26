<x-admin-layout>

    @push('styles')
        @livewireStyles
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <style>
            .upload__inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }

            .upload__btn {
                display: inline-block;
                font-weight: 600;
                color: #fff;
                text-align: center;
                min-width: 116px;
                padding: 5px;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid;
                background-color: #4045ba;
                border-color: #4045ba;
                border-radius: 10px;
                line-height: 26px;
                font-size: 14px;
            }

            .upload__btn:hover {
                background-color: unset;
                color: #4045ba;
                transition: all 0.3s ease;
            }

            .upload__btn-box {
                margin-bottom: 10px;
            }

            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 70px;
                padding: 0 10px;
                margin-bottom: 10px;
            }

            .upload__img-close,
            .upload__img-trash {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                /* background-color: rgba(0, 0, 0, 0.5); */
                position: absolute;
                top: 0px;
                right: 0px;
                text-align: center;
                line-height: 8px;
                z-index: 1;
                cursor: pointer;
            }

            .upload__img-close:after {
                font-size: 8px;
                color: white;
            }

            .upload__img-trash:after {
                font-size: 8px;
                color: white;
            }

            .img-bg {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                position: relative;
                padding-bottom: 100%;
            }

            .upload-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid gray;
                margin-top: 1px;
                padding-left: 2px;
                padding-right: 2px;
            }
        </style>
    @endpush
    <x-slot name="page_title">
        @php
            $medias = $course->uploads->toJson();
        @endphp
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
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

    @php
        $action = view('components.admin.course.topic', [
            'configuration' => $configuration ?? null,
            'topic' => null,
            'loop' => null,
        ])->render();
    @endphp
    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('Edit Course') }}
            </x-slot>
            <livewire:create-course :course="$course" :alloted_admin="$alloted_admin" />

        </x-admin.container-card>
        <div class="modal fade" id="remark-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Remarks</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                            <th>Last Modified By</th>
                                            <th>Last Modified On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-label for="remark">Remark</x-label>
                                    <textarea id="remark" cols="30" rows="10" class="form-control" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @push('scripts')
        <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('webroot/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            function reinitCKIntances() {
                $("textarea.ckeditor").each((e, a) => {
                    var instance = CKEDITOR.instances[a.id];
                    if (instance) {
                        CKEDITOR.remove(instance);
                        instance.destroy(true);
                        instance = null;
                    }
                    initCK(a.id);
                });
            }

            function initCK(id) {
                CKEDITOR.replace(id, {
                    toolbar: [{
                            name: "basicstyles",
                            items: [
                                "Bold",
                                "Italic",
                                "Underline",
                                "Strike",
                                "Subscript",
                                "Superscript",
                                "-",
                                "RemoveFormat",
                            ],
                        },
                        {
                            name: "paragraph",
                            items: [
                                "NumberedList",
                                "BulletedList",
                                "-",
                                "Outdent",
                                "Indent",
                                "-",
                                "Blockquote",
                                "CreateDiv",
                                "-",
                                "JustifyLeft",
                                "JustifyCenter",
                                "JustifyRight",
                                "JustifyBlock",
                            ],
                        },
                    ],
                    language: "en",
                    width: "100%",
                    height: "200px",
                });
            }

            function loadEditors() {
                var $editors = $("textarea.ckeditor");
                if ($editors.length) {
                    $editors.each(function() {
                        var editorID = $(this).attr("id");
                        var instance = CKEDITOR.instances[editorID];
                        if (instance) {
                            console.log('destroy');
                            instance.destroy(true);
                        }

                    });
                }
            }

            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000
                });
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: false,
                    searching: false,
                    ajax: {
                        url: "{{ route('manage.course.request.index', ['course' => $course->id]) }}",
                        data: function(d) {
                            const search_data = {}
                            $("#search_form").serializeArray()
                                .filter(row => row.value != "")
                                .forEach(row => {
                                    search_data[row.name] = row.value;
                                });
                            d.filter = search_data;
                        }
                    },
                    autoWidth: false,
                    order: [0, 'desc'],
                    columns: [{
                            data: row => row.DT_RowIndex,
                            name: 'id'
                        },
                        {
                            data: 'course.assigned_admin.category_course.course_name_en',
                            name: 'course.assignedAdmin.categoryCourse.course_name_en'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'editor_name',
                            name: 'editor.first_name',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });
                $("#show-remark").on("click", function() {
                    $("#remark-modal").modal("show");
                    $("#remark").closest('.row').hide();
                    $("#remark").val('');
                    table.ajax.reload();
                });
                $(document).on("click", ".view-remark", function() {
                    $("#remark").closest('.row').show();
                    $("#remark").val($(this).attr('data-remark'));
                });
            });
        </script>
    @endpush
    @push('scripts')
        @livewireScripts
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @endpush
</x-admin-layout>

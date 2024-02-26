<div class="col-md-12 topic_html">
    @if ($topic)
        yes
    @else
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    @if ($topic && $topic->course_status == 0)
                        <button type="button" class="btn bg-info btn-sm delete_topic"
                            data-route="{{ route('ajax.course-topic.destroy', encrypt($topic->id)) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    @else
                        <button type="button" class="btn bg-info btn-sm remove_html">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="topic_title">Topic Title <span class="text-danger">*</span></label>
                            <input type="hidden" name="id" id="" value="">
                            <input type="text" name="title" id=""
                                data-validations="{{ json_encode(['required' => true, 'messages' => ['required' => 'Topic Title is Required.']]) }}"
                                value="" class="form-control" placeholder="Enter Topic Title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="topic_summary">Topic Summary <span class="text-danger">*</span></label>
                            <textarea type="text" data-name="summary"
                                data-validations="{{ json_encode(['ckrequired' => true, 'maxlength' => 250]) }}" class="form-control ckeditor"
                                placeholder="Enter Topic Summary" name="" id=""></textarea>
                        </div>
                    </div>
                </div>
                @if (!$configuration)
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="col-md-12" style="border: solid; 1px;">
                                <legend>Video URL</legend>
                                <div class="form-group">
                                    <input type="hidden" data-name="course_video_id">
                                    <input type="text" data-name="course_video" class="form-control"
                                        data-validations="{{ json_encode(['url' => true]) }}"
                                        placeholder="upload video on youtube and type the youtube video link here">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload PDF</legend>
                                <div class="form-group">
                                    <div class="upload-row mp-1">
                                        <input type="file" data-name="course_pdf" class="course_pdf"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/pdf" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload PPT</legend>
                                <div class="form-group">
                                    <div class="upload-row mp-1">
                                        <input type="file" data-name="course_ppt" class="course_ppt"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload DOC</legend>
                                <div class="form-group">
                                    <div class="upload-row mp-1">
                                        <input type="file" data-name="course_doc" class="course_doc"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </fieldset>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            @if ($configuration->is_upload_video)
                                <fieldset class="col-md-12" style="border: solid; 1px;">
                                    <legend>Video URL @if ($configuration->is_upload_video_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </legend>
                                    <div class="form-group">
                                        <input type="hidden" data-name="course_video_id">
                                        <input type="text" data-name="course_video" class="form-control"
                                            data-validations="{{ json_encode(['url' => true, 'required' => $configuration->is_upload_video_required == 1 ? true : false]) }}"
                                            placeholder="upload video on youtube and type the youtube video link here">
                                    </div>
                                </fieldset>
                            @endif
                        </div>
                        @if ($configuration->is_upload_pdf)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PDF @if ($configuration->is_upload_pdf_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </legend>
                                    <div class="form-group">
                                        <div class="upload-row mp-1">
                                            <input type="file" data-name="course_pdf" class="course_pdf"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_pdf_required == 1 ? true : false]) }}"
                                                accept="application/pdf" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </fieldset>
                            </div>
                        @endif
                        @if ($configuration->is_upload_ppt)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PPT @if ($configuration->is_upload_ppt_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </legend>
                                    <div class="form-group">
                                        <div class="upload-row mp-1">
                                            <input type="file" data-name="course_ppt" class="course_ppt"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_ppt_required == 1 ? true : false]) }}"
                                                accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </fieldset>
                            </div>
                        @endif
                        @if ($configuration->is_upload_doc)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload DOC @if ($configuration->is_upload_doc_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </legend>
                                    <div class="form-group">
                                        <div class="upload-row mp-1">
                                            <input type="file" data-name="course_doc" class="course_doc"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_doc_required == 1 ? true : false]) }}"
                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </fieldset>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

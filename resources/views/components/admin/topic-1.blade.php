@props(['configuration', 'topics'])

<div class="col-md-12 topic_html">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-info btn-sm remove_html">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if ($topics)
                @foreach ($topics as $topic)
                    @php
                        $course_pdf = $topic->uploads->where('field_name', 'course_pdf')->all();
                        $course_ppt = $topic->uploads->where('field_name', 'course_ppt')->all();
                        $course_doc = $topic->uploads->where('field_name', 'course_doc')->all();
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="topic_title">Topic Title <span class="text-danger">*</span></label>
                                <input type="hidden" name="{{ 'topic[' . $loop->index . '][id]' }}"
                                    id="{{ 'topic_' . $loop->index . '_id' }}" data-name="id"
                                    value="{{ $topic->id }}">
                                <input type="text" data-name="title"
                                    name="{{ 'topic[' . $loop->index . '][title]' }}"
                                    id="{{ 'topic_' . $loop->index . '_title' }}"
                                    data-required="{{ json_encode(['required' => true, 'messages' => ['required' => 'Topic Title is Required.']]) }}"
                                    value="{{ old('topic[' . $loop->index . '][title]', $topic->title) }}"
                                    class="form-control" placeholder="Enter Topic Title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="topic_summary">Topic Summary</label>
                                <textarea type="text" data-name="summary" class="form-control" placeholder="Enter Topic Summary"
                                    name="{{ 'topic[' . $loop->index . '][summary]' }}" id="{{ 'topic_' . $loop->index . '_summary' }}">{{ old('topic[' . $loop->index . '][summary]', $topic->summary) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if (!$configuration)
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="col-md-12" style="border: solid; 1px;">
                                    <legend>Video URL</legend>
                                    <div class="form-group">
                                        <input type="text" data-name="course_video" class="form-control"
                                            name="{{ 'topic[' . $loop->index . '][course_video]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_video' }}"
                                            data-required="{{ json_encode(['url' => true]) }}"
                                            placeholder="upload video on youtube and type the youtube video link here">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PDF</legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_pdf" class="course_pdf"
                                            name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_pdf' }}" style="width: 100%;"
                                            data-files="{{ json_encode(mysql_escape_mimic(array_values($course_pdf))) }}"
                                            data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/pdf" multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PPT</legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_ppt" class="course_ppt"
                                            name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_ppt' }}" style="width: 100%;"
                                            data-files="{{ json_encode(mysql_escape_mimic(array_values($course_ppt))) }}"
                                            data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                            multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload DOC</legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_doc" class="course_doc"
                                            name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_doc' }}" style="width: 100%;"
                                            data-files="{{ json_encode(mysql_escape_mimic(array_values($course_doc))) }}"
                                            data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                            multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                @if ($configuration->is_upload_video)
                                    <fieldset class="col-md-12" style="border: solid; 1px;">
                                        <legend>Video URL <span class="text-danger">*</span></legend>
                                        <div class="form-group">
                                            <input type="text" data-name="course_video"
                                                name="{{ 'topic[' . $loop->index . '][course_video]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_video' }}"
                                                class="form-control"
                                                data-required="{{ json_encode(['url' => true]) }}"
                                                placeholder="upload video on youtube and type the youtube video link here">
                                        </div>
                                    </fieldset>
                                @endif
                            </div>
                            @if ($configuration->is_upload_pdf)
                                <div class="col-md-6">
                                    <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                        <legend>Upload PDF <span class="text-danger">*</span></legend>
                                        <div class="form-group">
                                            <input type="file" data-name="course_pdf"
                                                name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_pdf' }}" class="course_pdf"
                                                data-files="{{ json_encode(mysql_escape_mimic(array_values($course_pdf))) }}"
                                                style="width: 100%;"
                                                data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/pdf" multiple />
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                    </fieldset>
                                </div>
                            @endif
                            @if ($configuration->is_upload_ppt)
                                <div class="col-md-6">
                                    <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                        <legend>Upload PPT <span class="text-danger">*</span></legend>
                                        <div class="form-group">
                                            <input type="file" data-name="course_ppt"
                                                name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_ppt' }}" class="course_ppt"
                                                data-files="{{ json_encode(mysql_escape_mimic(array_values($course_ppt))) }}"
                                                style="width: 100%;"
                                                data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                                multiple />
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                    </fieldset>
                                </div>
                            @endif
                            @if ($configuration->is_upload_doc)
                                <div class="col-md-6">
                                    <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                        <legend>Upload DOC <span class="text-danger">*</span></legend>
                                        <div class="form-group">
                                            <input type="file" data-name="course_doc"
                                                name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_doc' }}" class="course_doc"
                                                data-files="{{ json_encode(mysql_escape_mimic(array_values($course_doc))) }}"
                                                data-required="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                style="width: 100%;" multiple />
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                    </fieldset>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="topic_title">Topic Title <span class="text-danger">*</span></label>
                            <input type="hidden" data-name="id">
                            <input type="text" data-name="title"
                                data-required="{{ json_encode(['required' => true, 'messages' => ['required' => 'Topic Title is Required.']]) }}"
                                class="form-control" placeholder="Enter Topic Title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="topic_summary">Topic Summary</label>
                            <textarea type="text" data-name="summary" class="form-control" placeholder="Enter Topic Summary">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                </div>
                @if (!$configuration)
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="col-md-12" style="border: solid; 1px;">
                                <legend>Video URL</legend>
                                <div class="form-group">
                                    <input type="text" data-name="course_video" class="form-control"
                                        data-required="{{ json_encode(['url' => true]) }}"
                                        placeholder="upload video on youtube and type the youtube video link here">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload PDF</legend>
                                <div class="form-group">
                                    <input type="file" data-name="course_pdf" class="course_pdf"
                                        style="width: 100%;"
                                        data-required="{{ json_encode(['accept' => 'application/pdf']) }}"
                                        accept="application/pdf" multiple />
                                </div>
                                <div class="upload__img-wrap"></div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload PPT</legend>
                                <div class="form-group">
                                    <input type="file" data-name="course_ppt" class="course_ppt"
                                        style="width: 100%;"
                                        data-required="{{ json_encode(['accept' => 'application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation']) }}"
                                        accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                        multiple />
                                </div>
                                <div class="upload__img-wrap"></div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                <legend>Upload DOC</legend>
                                <div class="form-group">
                                    <input type="file" data-name="course_doc" class="course_doc"
                                        style="width: 100%;"
                                        data-required="{{ json_encode(['accept' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document']) }}"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        multiple />
                                </div>
                                <div class="upload__img-wrap"></div>
                            </fieldset>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            @if ($configuration->is_upload_video)
                                <fieldset class="col-md-12" style="border: solid; 1px;">
                                    <legend>Video URL <span class="text-danger">*</span></legend>
                                    <div class="form-group">
                                        <input type="text" data-name="course_video" class="form-control"
                                            data-required="{{ json_encode(['url' => true]) }}"
                                            placeholder="upload video on youtube and type the youtube video link here">
                                    </div>
                                </fieldset>
                            @endif
                        </div>
                        @if ($configuration->is_upload_pdf)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PDF <span class="text-danger">*</span></legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_pdf" class="course_pdf"
                                            style="width: 100%;"
                                            data-required="{{ json_encode(['accept' => 'application/pdf']) }}"
                                            multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                        @endif
                        @if ($configuration->is_upload_ppt)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload PPT <span class="text-danger">*</span></legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_ppt" class="course_ppt"
                                            style="width: 100%;"
                                            data-required="{{ json_encode(['accept' => 'application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation']) }}"
                                            accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                            multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                        @endif
                        @if ($configuration->is_upload_doc)
                            <div class="col-md-6">
                                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                                    <legend>Upload DOC <span class="text-danger">*</span></legend>
                                    <div class="form-group">
                                        <input type="file" data-name="course_doc" class="course_doc"
                                            data-required="{{ json_encode(['accept' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document']) }}"
                                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                            style="width: 100%;" multiple />
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </fieldset>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@props(['configuration' => null, 'topic' => null, 'loop' => null])

<div class="container-fluid topic_html">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn bg-info btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                @if ($topic)
                    @if ($topic->course_status == 0)
                        <button type="button" class="btn bg-info btn-sm delete_topic"
                            data-route="{{ route('ajax.course-topic.destroy', encrypt($topic->id)) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                @else
                    <button type="button" class="btn bg-info btn-sm remove_topic">
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if ($topic)
                @php
                    $course_pdfs = $topic->uploads->where('field_name', 'course_pdf')->all();
                    $course_ppts = $topic->uploads->where('field_name', 'course_ppt')->all();
                    $course_docs = $topic->uploads->where('field_name', 'course_doc')->all();
                    $course_video = $topic->uploads->where('field_name', 'course_video')->first();
                @endphp
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="topic_title">Topic Title <span class="text-danger">*</span></x-label>
                            <input type="hidden" name="{{ 'topic[' . $loop->index . '][id]' }}"
                                id="{{ 'topic_' . $loop->index . '_id' }}" data-name="id" value="{{ $topic->id }}">
                            <input type="text" data-name="title" name="{{ 'topic[' . $loop->index . '][title]' }}"
                                id="{{ 'topic_' . $loop->index . '_title' }}"
                                data-validations="{{ json_encode(['required' => true, 'messages' => ['required' => 'Topic Title is Required.']]) }}"
                                value="{{ old('topic[' . $loop->index . '][title]', $topic->update_title ? $topic->update_title : $topic->title) }}"
                                class="form-control" placeholder="Enter Topic Title">
                        </div>
                    </div>
                    @if (!$configuration)
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <x-label>Video URL</x-label>
                                <div class="form-group">
                                    <input type="hidden" name="{{ 'topic[' . $loop->index . '][course_video_id]' }}"
                                        id="{{ 'topic_' . $loop->index . '_course_id' }}"
                                        value="{{ $course_video?->id }}" data-name="course_video_id">
                                    <input type="text" data-name="course_video" class="form-control"
                                        name="{{ 'topic[' . $loop->index . '][course_video]' }}"
                                        id="{{ 'topic_' . $loop->index . '_course_video' }}"
                                        data-validations="{{ json_encode(['url' => true]) }}"
                                        value="{{ $course_video?->update_file_path ? $course_video?->update_file_path : $course_video?->file_path ?? '' }}"
                                        placeholder="upload video on youtube and type the youtube video link here">
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($configuration->is_upload_video)
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <x-label>Video URL @if ($configuration->is_upload_video_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        <input type="hidden"
                                            name="{{ 'topic[' . $loop->index . '][course_video_id]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_video_id' }}"
                                            value="{{ $course_video?->id ?? '' }}" data-name="course_video_id">
                                        <input type="text" data-name="course_video"
                                            name="{{ 'topic[' . $loop->index . '][course_video]' }}"
                                            id="{{ 'topic_' . $loop->index . '_course_video' }}" class="form-control"
                                            data-validations="{{ json_encode(['url' => true, 'required' => $configuration->is_upload_video_required == 1 ? true : false]) }}"
                                            value="{{ $course_video?->update_file_path ? $course_video?->update_file_path : $course_video?->file_path ?? '' }}"
                                            placeholder="upload video on youtube and type the youtube video link here">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="topic_summary">Topic Summary <span class="text-danger">*</span></x-label>
                            <textarea type="text" data-name="summary"
                                data-validations="{{ json_encode(['ckrequired' => true, 'maxlength' => 250]) }}" class="form-control editor"
                                placeholder="Enter Topic Summary" name="{{ 'topic[' . $loop->index . '][summary]' }}"
                                id="{{ 'topic_' . $loop->index . '_summary' }}">{{ old('topic[' . $loop->index . '][summary]', $topic->update_summary ? $topic->update_summary : $topic->summary) }}</textarea>
                        </div>
                    </div>
                    @if (!$configuration)
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload PDF</x-label>
                                <div class="form-group">
                                    @if ($course_pdfs)
                                        @foreach ($course_pdfs as $course_pdf)
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_pdf" class="course_pdf"
                                                    name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_pdf' }}"
                                                    data-files="{{ json_encode(mysql_escape_mimic($course_pdf)) }}"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                    accept="application/pdf"
                                                    data-id="{{ encrypt($course_pdf->id) }}" />
                                                <div class="upload__img-wrap"></div>
                                                <button type="button" class="btn btn-danger btn-sm delete_upload_row"
                                                    data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_pdf->id)]) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_pdf" class="course_pdf"
                                                name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_pdf' }}"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/pdf" />
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"
                                    {{ count($course_pdfs) == 2 ? 'disabled' : '' }}><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload PPT</x-label>
                                <div class="form-group">
                                    @if ($course_ppts)
                                        @foreach ($course_ppts as $course_ppt)
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_ppt" class="course_ppt"
                                                    name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_ppt' }}"
                                                    data-files="{{ json_encode(mysql_escape_mimic($course_ppt)) }}"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                    accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                                    data-id="{{ encrypt($course_ppt->id) }}" />
                                                <div class="upload__img-wrap"></div>
                                                <button type="button" class="btn btn-danger btn-sm delete_upload_row"
                                                    data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_ppt->id)]) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_ppt" class="course_ppt"
                                                name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_ppt' }}"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"
                                    {{ count($course_ppts) == 2 ? 'disabled' : '' }}><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload DOC</x-label>
                                <div class="form-group">
                                    @if ($course_docs)
                                        @foreach ($course_docs as $course_doc)
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_doc" class="course_doc"
                                                    name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_doc' }}"
                                                    data-files="{{ json_encode(mysql_escape_mimic($course_doc)) }}"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                    accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                    data-id="{{ encrypt($course_doc->id) }}" />
                                                <div class="upload__img-wrap"></div>
                                                <button type="button" class="btn btn-danger btn-sm delete_upload_row"
                                                    data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_doc->id)]) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_doc" class="course_doc"
                                                name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                                id="{{ 'topic_' . $loop->index . '_course_doc' }}"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"
                                    {{ count($course_docs) == 2 ? 'disabled' : '' }}><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    @else
                        @if ($configuration->is_upload_pdf)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload PDF @if ($configuration->is_upload_pdf_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        @if ($course_pdfs)
                                            @foreach ($course_pdfs as $course_pdf)
                                                <div class="upload-row mp-1 flex-wrap">
                                                    <input type="file" data-name="course_pdf"
                                                        name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                                        id="{{ 'topic_' . $loop->index . '_course_pdf' }}"
                                                        class="course_pdf"
                                                        data-files="{{ json_encode(mysql_escape_mimic($course_pdf)) }}"
                                                        data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_pdf_required == 1 && !$course_pdf->id ? true : false]) }}"
                                                        accept="application/pdf"
                                                        data-id="{{ encrypt($course_pdf->id) }}" />
                                                    <div class="upload__img-wrap"></div>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete_upload_row"
                                                        data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_pdf->id)]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_pdf"
                                                    name="{{ 'topic[' . $loop->index . '][course_pdf][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_pdf' }}"
                                                    class="course_pdf"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_pdf_required == 1 ? true : false]) }}"
                                                    accept="application/pdf" />
                                            </div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file"
                                        {{ count($course_pdfs) == 2 ? 'disabled' : '' }} type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                        @if ($configuration->is_upload_ppt)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload PPT @if ($configuration->is_upload_ppt_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        @if ($course_ppts)
                                            @foreach ($course_ppts as $course_ppt)
                                                <div class="upload-row mp-1 flex-wrap">
                                                    <input type="file" data-name="course_ppt"
                                                        name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                                        id="{{ 'topic_' . $loop->index . '_course_ppt' }}"
                                                        class="course_ppt"
                                                        data-files="{{ json_encode(mysql_escape_mimic($course_ppt)) }}"
                                                        data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_ppt_required == 1 && !$course_ppt ? true : false]) }}"
                                                        accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                                        data-id="{{ encrypt($course_ppt->id) }}" />
                                                    <div class="upload__img-wrap"></div>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete_upload_row"
                                                        data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_ppt->id)]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_ppt"
                                                    name="{{ 'topic[' . $loop->index . '][course_ppt][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_ppt' }}"
                                                    class="course_ppt"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_ppt_required == 1 ? true : false]) }}"
                                                    accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                            </div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file"
                                        {{ count($course_ppts) == 2 ? 'disabled' : '' }} type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                        @if ($configuration->is_upload_doc)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload DOC @if ($configuration->is_upload_doc_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        @if ($course_docs)
                                            @foreach ($course_docs as $course_doc)
                                                <div class="upload-row mp-1 flex-wrap">
                                                    <input type="file" data-name="course_doc"
                                                        name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                                        id="{{ 'topic_' . $loop->index . '_course_doc' }}"
                                                        class="course_doc"
                                                        data-files="{{ json_encode(mysql_escape_mimic($course_doc)) }}"
                                                        data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_doc_required == 1 && !$course_doc->id ? true : false]) }}"
                                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                        data-id="{{ encrypt($course_doc->id) }}" />
                                                    <div class="upload__img-wrap"></div>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete_upload_row"
                                                        data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course_doc->id)]) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="upload-row mp-1 flex-wrap">
                                                <input type="file" data-name="course_doc"
                                                    name="{{ 'topic[' . $loop->index . '][course_doc][]' }}"
                                                    id="{{ 'topic_' . $loop->index . '_course_doc' }}"
                                                    class="course_doc"
                                                    data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_doc_required == 1 ? true : false]) }}"
                                                    accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                            </div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file"
                                        {{ count($course_docs) == 2 ? 'disabled' : '' }} type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="topic_title">Topic Title <span class="text-danger">*</span></x-label>
                            <input type="hidden" data-name="id">
                            <input type="text" data-name="title"
                                data-validations="{{ json_encode(['required' => true, 'messages' => ['required' => 'Topic Title is Required.']]) }}"
                                class="form-control" placeholder="Enter Topic Title">
                        </div>
                    </div>
                    @if (!$configuration)
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <x-label>Video URL</x-label>
                                <div class="form-group">
                                    <input type="hidden" data-name="course_video_id">
                                    <input type="text" data-name="course_video" class="form-control"
                                        data-validations="{{ json_encode(['url' => true]) }}"
                                        placeholder="upload video on youtube and type the youtube video link here">
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($configuration->is_upload_video)
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <x-label>Video URL @if ($configuration->is_upload_video_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        <input type="hidden" data-name="course_video_id">
                                        <input type="text" data-name="course_video" class="form-control"
                                            data-validations="{{ json_encode(['url' => true, 'required' => $configuration->is_upload_video_required == 1 ? true : false]) }}"
                                            placeholder="upload video on youtube and type the youtube video link here">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label for="topic_summary">Topic Summary <span class="text-danger">*</span></x-label>
                            <textarea type="text" data-name="summary"
                                data-validations="{{ json_encode(['ckrequired' => true, 'maxlength' => 250]) }}" class="form-control editor"
                                placeholder="Enter Topic Summary">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                    @if (!$configuration)
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload PDF</x-label>
                                <div class="form-group">
                                    <div class="upload-row mp-1 flex-wrap">
                                        <input type="file" data-name="course_pdf" class="course_pdf"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/pdf" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload PPT</x-label>
                                <div class="form-group">
                                    <div class="upload-row mp-1 flex-wrap">
                                        <input type="file" data-name="course_ppt" class="course_ppt"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 upload-file">
                                <x-label>Upload DOC</x-label>
                                <div class="form-group">
                                    <div class="upload-row mp-1 flex-wrap">
                                        <input type="file" data-name="course_doc" class="course_doc"
                                            data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true]) }}"
                                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    @else
                        @if ($configuration->is_upload_pdf)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload PDF @if ($configuration->is_upload_pdf_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_pdf" class="course_pdf"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_pdf_required == 1 ? true : false]) }}"
                                                accept="application/pdf" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                        @if ($configuration->is_upload_ppt)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload PPT @if ($configuration->is_upload_ppt_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_ppt" class="course_ppt"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_ppt_required == 1 ? true : false]) }}"
                                                accept="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                        @if ($configuration->is_upload_doc)
                            <div class="col-md-6">
                                <div class="col-md-12 upload-file">
                                    <x-label>Upload DOC @if ($configuration->is_upload_doc_required == 1 ? true : false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </x-label>
                                    <div class="form-group">
                                        <div class="upload-row mp-1 flex-wrap">
                                            <input type="file" data-name="course_doc" class="course_doc"
                                                data-validations="{{ json_encode(['limit_file_upload' => true, 'validate_file_size' => true, 'required' => $configuration->is_upload_doc_required == 1 ? true : false]) }}"
                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-2 mb-2 add-file" type="button"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

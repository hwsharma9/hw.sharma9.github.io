<form method="POST" action="" enctype="multipart/form-data" id="quickForm" wire:submit.prevent="save">
    @csrf
    <input type="hidden" name="replaced_media_id">
    <input type="hidden" name="saved_as">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <x-label>Category <span class="text-danger">*</span></x-label>
                <input class="form-control" disabled value="{{ $alloted_admin->courseCategory->category_name_en }}" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <x-label>Course</x-label>
                <input class="form-control" disabled value="{{ $alloted_admin->categoryCourse->course_name_en }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <x-label for="description">Course Description <span class="text-danger">*</span></x-label>
                <textarea type="text" name="description" class="form-control ckeditor" id="course_description"
                    placeholder="Enter Course Description">{{ old('description', $course->update_description ? $course->update_description : $course->description) }}</textarea>
            </div>
        </div>
        <div class="col-md-6 upload-file">
            <div class="d-flex">
                <fieldset class="col-md-12 upload-file" style="border: solid; 1px;">
                    <legend>Course Thumbnail</legend>
                    <div class="form-group">
                        @if ($course->upload)
                            <div class="upload-row mp-1">
                                <input type="file" name="course_thumbnail" class="course_thumbnail"
                                    id="course_thumbnail" data-files="{{ $course->upload }}"
                                    data-id="{{ encrypt($course->upload->id) }}" accept="image/png, image/jpeg"
                                    wire:change="updateCourseMedia" />
                                <div class="upload__img-wrap"></div>
                                <button type="button" class="btn btn-danger delete_upload_row"
                                    data-route="{{ route('ajax.course.media.destroy', ['course_media' => encrypt($course->upload->id)]) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <div class="upload-row mp-1">
                                <input type="file" name="course_thumbnail" class="course_thumbnail"
                                    id="course_thumbnail" accept="image/png, image/jpeg" />
                            </div>
                        @endif
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="row" id="topics_container">
        @if ($course_topics->count())
            @foreach ($course_topics as $topic)
                <livewire:create-course :course="$course" :alloted_admin="$alloted_admin" :topic="$topic" />
            @endforeach
        @else
            <livewire:create-course-topic :course="$course" :alloted_admin="$alloted_admin" />
        @endif
    </div>
    <div class="card-footer d-flex justify-content-between">
        <span>
            <button type="submit" class="btn btn-success" name="action" value="request">Request to
                Approve</button>
            <button type="submit" class="btn btn-primary" name="action" value="draft">Save as
                Draft</button>
            @if ($course->requests->count())
                <button type="butotn" class="btn btn-secondary" id="show-remark">Action</button>
            @endif
        </span>
        <span>
            <button type="button" class="btn btn-secondary" id="add_topic">Add More Topics</button>
        </span>
    </div>
</form>

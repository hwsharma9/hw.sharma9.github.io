<div class="course-item bg-light">
    @php
        $course_media = $course?->upload?->file_path ? $course->upload->file_path : asset('frontend/img/course-1.jpg');
        $course_media_name = $course?->upload ? $course->upload->original_name : 'Course Media';
    @endphp
    <div class="position-relative overflow-hidden">
        <img class="img-fluid" src="{{ $course_media }}" alt="{{ $course_media_name }}">
        <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
            <a href="{{ route('root.courses.show', ['course' => encrypt($course->id)]) }}"
                class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                style="border-radius: 30px 0 0 30px;">View</a>
            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3"
                style="border-radius: 0 30px 30px 0;">Enroll Now</a>
        </div>
    </div>
    <div class="text-center p-4 pb-0 min-h">
        <h5 class="mb-4">{{ $course->assignedAdmin->categoryCourse->course_name_en }}</h5>
    </div>
    <div class="d-flex border-top">
        <small class="flex-fill text-center border-end py-2">
            <i class="fa fa-clock text-primary me-2"></i> Duration - 10 Hrs
        </small>
    </div>
</div>

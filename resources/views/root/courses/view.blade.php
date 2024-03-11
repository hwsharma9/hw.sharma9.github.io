<x-app-layout>
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-4 mb-4 " style="min-height: 380px; background-color: #343747 !important;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white"
                                    href="#">{{ $course->assignedAdmin->courseCategory->category_name_en }}</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">
                                {{ $course->assignedAdmin->categoryCourse->course_name_en }}</li>
                        </ol>
                    </nav>
                    <p class="display-6 text-white animated slideInDown mb-4">
                        {{ $course->assignedAdmin->categoryCourse->course_name_en }}</p>
                    <div class="text-white mt-4 mb-4" style="font-size: 18px;">
                        {!! $course->description !!}
                    </div>
                    {{-- <p class="text-white mt-4 mb-4" style="font-size: 18px;">Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Odio, unde pariatur nemo obcaecati perferendis sint necessitatibus tenetur?
                        Aperiam ipsa, minus earum ex labore reprehenderit sed dolores, eum ut veritatis harum?</p> --}}

                    <nav>
                        <ol class="view-course-update ">
                            <li class="view-course-update"><a class="text-white" href="#"><i
                                        class="fas fa-clock"></i> Last updated
                                    {{ Carbon\Carbon::parse($course->updated_at)->format('d/Y') }}</a></li>
                            <li class="view-course-update text-white active" aria-current="page"><a class="text-white"
                                    href="#"><i class="fas fa-globe"></i> English</a></li>
                        </ol>
                    </nav>
                    <p class="text-white">4.50 <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star"
                            aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star"
                            aria-hidden="true"></i><i class="fa fa-star-half" aria-hidden="true"></i></p>

                </div>

                <div class="col-lg-4" style="position: relative;">
                    <div class="view-course-right-column">
                        <div class="position-relative overflow-hidden">
                            @php
                                $course_media = $course?->upload?->file_path
                                    ? $course->upload->file_path
                                    : asset('frontend/img/course-1.jpg');
                                $course_media_name = $course?->upload ? $course->upload->original_name : 'Course Media';
                            @endphp
                            <img class="img-fluid" src="{{ $course_media }}" alt="{{ $course_media_name }}">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4"
                                style="top:50%">
                                <!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square " ><i class="fa fa-play" aria-hidden="true"></i></a> -->
                                <button type="button" class="btn btn-lg btn-primary btn-lg-square"
                                    data-bs-toggle="modal" data-src="https://www.youtube.com/embed/Jfrjeg26Cwk"
                                    data-bs-target="#myModal">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div
                                class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4 mt-4">

                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end"
                                    style="border-radius: 30px 30px;">Preview this course</a>

                            </div>
                        </div>
                        <div class="col-12 px-4 list mt-4 mb-4">
                            <h5>This course includes:</h5>
                            <ul>
                                @if ($course->topics)
                                    <li>{{ $course->topics->count() }} topics</li>
                                @endif
                                @if ($course->topics_uploads_count > 0)
                                    <li>{{ $course->topics_uploads_count }} downloadable resources</li>
                                @endif
                                <li>Full lifetime access</li>
                                <li>Certificate of completion</li>
                            </ul>
                        </div>

                        <div class="col-12 mt-4 text-center mb-4">
                            <a class="btn btn-primary px-4" href="">Enroll Now </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                    </button>
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- About Start -->
    <div class="container-xxl ">
        <div class="container p-0">
            <!-- Courses Start -->
            <div class="container py-5">
                <div class="row list">
                    <div class="col-lg-8 p-4" style="border: 1px solid #d1d7dc; padding: 2.4rem 0;">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">

                            <h4>Course Information</h4>
                            <p class="text-primary">Skill Development</p>

                            <ul>
                                <li>Full Name Solar Technician (Electrical) - (Trade Code-560)</li>
                                <li>Category Skill Development</li>
                                <li>Course Duration 1</li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if ($course->topics)
                    <div class="row mt-4 list">
                        <div class="wow fadeIndown p-0" data-wow-delay="0.1s">

                            <h4>This course includes:</h4>

                            <div class="col-lg-8 p-0">
                                <div class="accordion" id="regularAccordionRobots">
                                    @foreach ($course->topics as $topic)
                                        <div class="accordion-item">
                                            <h2 id="{{ 'regularHeading' . $topic->id }}" class="accordion-header">
                                                <button
                                                    class="accordion-button @if ($loop->index != 0) collapsed @endif"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ 'regularCollapse' . $topic->id }}"
                                                    @if ($loop->index == 0) aria-expanded="true" @endif
                                                    aria-controls="{{ 'regularCollapse' . $topic->id }}">
                                                    {{ $topic->title }}
                                                </button>
                                            </h2>
                                            <div id="{{ 'regularCollapse' . $topic->id }}"
                                                class="accordion-collapse collapse @if ($loop->index == 0) show @endif"
                                                aria-labelledby="{{ 'regularHeading' . $topic->id }}"
                                                data-bs-parent="#regularAccordionRobots">
                                                <div class="accordion-body">
                                                    {!! $topic->summary !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="row mt-4 list">
                    <div class="wow fadeInUp" data-wow-delay="0.1s">

                        <h4>Course Description :</h4>
                        <p class="text-primary">Courtesy:</p>
                        <ul>
                            <li>Bharat Skill</li>
                            <li>Directorate General of Training (DGT)</li>
                            <li>Ministry of Skill Development and Entrepreneurship</li>
                            <li>Government of India</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Courses End -->


        </div>
    </div>
    <!-- About End -->
</x-app-layout>

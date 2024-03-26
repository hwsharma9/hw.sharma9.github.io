<x-app-layout>
    <!-- hero slider -->
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            @if ($sliders)
                @foreach ($sliders as $slider)
                    <div class="owl-carousel-item position-relative">
                        <img class="img-fluid" src="{{ asset('frontend/img/carousel-1.jpg') }}" alt="">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                            style="background: rgba(24, 29, 56, .7);">
                            <div class="container">
                                <div class="row justify-content-start">
                                    <div class="col-sm-10 col-lg-8">
                                        <!-- <h5 class="text-primary text-uppercase mb-3 animated slideInDown">e-Shiksha  </h5> -->
                                        <h1 class="display-4 text-white animated slideInDown mb-4"> Learning Management
                                            System
                                        </h1>

                                        <a href=""
                                            class="btn btn-primary py-md-2 px-md-4 me-3 animated slideInLeft"
                                            style=" border-radius: 40px; ">Read More</a>
                                        <a href="" class="btn btn-light py-md-2 px-md-4 animated slideInRight"
                                            style=" border-radius: 40px; ">Enroll Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            {{-- <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('frontend/img/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">

                                <h1 class="display-4 text-white animated slideInDown mb-4"> Learning Management System
                                </h1>

                                <a href="" class="btn btn-primary py-md-2 px-md-4 me-3 animated slideInLeft"
                                    style=" border-radius: 40px; ">Read More</a>
                                <a href="" class="btn btn-light py-md-2 px-md-4 animated slideInRight"
                                    style=" border-radius: 40px; ">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
    <!-- Carousel End -->



    <div class="container mb-4">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">

            <h1>Quick Information</h1>
        </div>
        <div class="row">
            <div class="four col-md-6 col-lg-3  wow fadeInUp" data-wow-delay="0.1s">
                <div class="counter-box ">
                    <span class="counter">{{ $department_onboarded_count }}</span>
                    <p>Total Departments Onboarded</p>
                </div>
            </div>
            <div class="four col-md-6 col-lg-3 wow zoomIn" data-wow-delay="0.3s">
                <div class="counter-box">
                    <span class="counter">{{ $courses_enrolled }}</span>
                    <p>Courses Enrolled </p>
                </div>
            </div>
            <div class="four col-md-6 col-lg-3 wow zoomIn" data-wow-delay="0.3s">
                <div class="counter-box">
                    <span class="counter">{{ $registered_users }}</span>
                    <p>Total Users Registered</p>
                </div>
            </div>
            <div class="four col-md-6 col-lg-3 wow zoomIn" data-wow-delay="0.3s">
                <div class="counter-box"> <span class="counter">350</span>
                    <p>Total Certification</p>
                </div>
            </div>

        </div>
    </div>




    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100"
                            src="{{ asset('frontend/img/e-book1.png') }}" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s" style="display: table;">
                    <div style="vertical-align: middle; display: table-cell;">
                        {{-- <p class="mb-4">eShiksha is an education management portal which simplifies the management and
                            provides enormous facilities to an Institute. Our portal assists educators to manage,
                            analyze and report extensive data, while making your institutes management "A cashless and
                            paperless management". </p> --}}
                        {!! config('app.locale') == 'hi' ? $page->description_hi : $page->description_en !!}
                        <br>
                        <a class="btn btn-primary py-2 px-4 mt-2" href="" style=" border-radius: 40px; ">Find out
                            more
                            <i class="fas fa-arrow-alt-circle-right" style="margin-left: 10px; "></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->



    <!-- Categories Start -->
    <div class="container-fluid py-5 category" style="background-color: #eef4f5;  padding-left: 0; padding-right: 0;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">

                <h1 class="mb-5">Onboarded Departments</h1>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">MAP_IT - TCU</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">MAP_IT - TCU</h4>

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/departments/iti.jpg') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">Skill Development</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/departments/iti.jpg') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">Skill Development</h4>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/departments/phq.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">Police Head Quarters</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/departments/phq.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">Police Head Quarters</h4>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/departments/mptaas.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">MP-TAAS</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/departments/mptaas.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">MP-TAAS</h4>

                        </div>
                    </div>
                </div>



                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/departments/epco.jpg') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">EPCO</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/departments/epco.jpg') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">EPCO</h4>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">Higher Education</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">Higher Education</h4>

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/departments/dmi.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">DMI</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/departments/dmi.png') }}" alt=""
                                style="height:70px; " />
                            <h4 class="mt-2">DMI</h4>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
                    <div class="thumbnail">
                        <div class="thumb-logo">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">MP-Tender</h4>
                        </div>
                        <div class="caption">
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="" style="height:70px; " />
                            <h4 class="mt-2">MP-Tender</h4>

                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a class="btn btn-primary py-2 px-4 mt-2" href="" style=" border-radius: 40px; ">Find out
                        more <i class="fas fa-arrow-alt-circle-right" style="margin-left: 10px; "></i></a>
                </div>

            </div>
        </div>
    </div>
    <!-- Categories Start -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container ">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">

                <h1 class="mb-5">Our Courses</h1>
            </div>
            <div class="owl-carousel courses-carousel position-relative">
                @if ($courses)
                    @foreach ($courses as $course)
                        <div class="owl-item @if ($loop->index < 3) active @endif">
                            <div class="wow fadeInUp" data-wow-delay="0.1s">
                                <x-front.courses.CourseItem :course="$course" />
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-12 text-center">
                <a class="btn btn-primary py-2 px-4 mt-4" href="{{ route('root.courses.index') }}"
                    style=" border-radius: 40px; ">Find out more
                    <i class="fas fa-arrow-alt-circle-right" style="margin-left: 10px; "></i></a>
            </div>
        </div>
    </div>
    <!-- Courses End -->

    <!-- footer logos Start -->

    <div id="logo-slider">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-12" style="padding:0">

                    <div class="footer-section-row">
                        <div class="first-img custom7 owl-carousel owl-theme owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage"
                                    style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; ">

                                    <div class="owl-item active">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/cmhelpline.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/fomp.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/indiaportal.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/investmp.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/lokseva.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mapit.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mpcode.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mpdashboard.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mpdashboard.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mpgov.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mpinfo.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/mptourism.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="item">
                                            <img src="{{ asset('frontend/img/departments/scroll/rajbhavan.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="owl-nav disabled">
                                <button type="button" role="presentation" class="owl-prev">
                                    <span aria-label="Previous">‹</span></button><button type="button"
                                    role="presentation" class="owl-next">
                                    <span aria-label="Next">›</span></button>
                            </div>
                            <div class="owl-dots ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer logos End -->
</x-app-layout>

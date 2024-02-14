<x-app-layout>
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-4 mb-5 page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">{{ $page->title_en }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->title_en }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->




    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100"
                            src="{{ asset('frontend/img/e-book.png') }}" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s" style="display: table;">
                    <div style="vertical-align: middle; display: table-cell;">
                        <h6 class="section-title bg-white text-start text-primary pe-3">
                            {{ config('app.locale') == 'hi' ? $page->title_hi : $page->title_en }}</h6>
                        {!! config('app.locale') == 'hi' ? $page->description_hi : $page->description_en !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
</x-app-layout>

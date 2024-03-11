<x-app-layout>
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-4 mb-4 page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->




    <!-- About Start -->
    <div class="container-xxl ">

        <div class="container">
            <div class="row mb-4">
                <div class="innertitle d-flex justify-content-end mb-4 p-0">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm pull-right"
                        onclick="$('#print').print();"><span class="fa fa-print"></span> Print</a>
                </div>
                <div class="col-12">
                    <div class=" wow fadeInUp" data-wow-delay="0.1s"
                        style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                        <h4>Search Course</h4>
                    </div>
                </div>
                <div class="col-lg-12 wow fadeInUp " style="background-color: #06bbcc;">
                    <div class="search-title">
                        <form action="{{ route('root.courses.index') }}" method="get">
                            @php
                                $filter = request()->get('filter');
                            @endphp
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Department</label>
                                        <select name="filter[department]" id="department" class="form-control">
                                            <option value="">Please Select</option>
                                            @if ($departments)
                                                @foreach ($departments as $department)
                                                    @php
                                                        $is_selected = '';
                                                        if (
                                                            isset($filter['department']) &&
                                                            decrypt($filter['department']) == $department->id
                                                        ) {
                                                            $is_selected = 'selected';
                                                        }
                                                    @endphp
                                                    <option value="{{ encrypt($department->id) }}" {{ $is_selected }}>
                                                        {{ $department->title_en }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Search By Course Name</label>
                                        @php
                                            $is_course_name = '';
                                            if (isset($filter['course_name']) && !empty(trim($filter['course_name']))) {
                                                $is_course_name = $filter['course_name'];
                                            }
                                        @endphp
                                        <input type="text" name="filter[course_name]" value="{{ $is_course_name }}"
                                            id="course_name" class="form-control" placeholder="Search By Title">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-28">
                                        <br>
                                        <button type="submit"
                                            class="btn btn-dark py-md-2 px-md-4 animated slideInRight"
                                            style=" border-radius: 40px; margin-right:20px" id="search">
                                            Search</button>
                                        <button class="btn btn-light py-md-2 px-md-4 animated slideInRight"
                                            style=" border-radius: 40px; " onclick="searchFilter(0,1);"
                                            id="search-all"><i class="fas fa-refresh"></i>
                                            Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Courses Start -->
            <div class="container-xxl py-5">
                <div class="container ">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="mb-5">All Courses</h1>
                    </div>
                    <div class="row">
                        @if ($courses)
                            @foreach ($courses as $course)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <x-front.courses.CourseItem :course="$course" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!-- Courses End -->

            <div class="row mb-4 ">
                <div class="col-12 text-center">
                    {{ $courses->links() }}
                    {{-- <ul class="pagination pagination-lg d-flex justify-content-center">
                        <li class="page-item"><a class="page-link" href="#" aria-label="Previous">&laquo;</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link " href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                        <li class="page-item"><a class="page-link" href="#">9</a></li>
                        <li class="page-item"><a class="page-link" href="#" aria-label="Next">&raquo;</a></li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
</x-app-layout>

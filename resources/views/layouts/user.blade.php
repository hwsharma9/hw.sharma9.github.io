<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('webroot/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- IonIcons -->
    <link rel="stylesheet" href="{{ asset('webroot/plugins/ionicons-2.0.1/css/ionicons.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <style>
        label.error {
            color: red;
            font-size: 1rem;
            font-weight: 400;
        }

        .loading {
            z-index: 1055;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .loading-content {
            position: absolute;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            top: 50%;
            left: 50%;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        fieldset {
            border: 1px solid #ced4da !important;
            margin-bottom: 15px;
        }

        fieldset legend {
            width: auto;
            padding: 0 10px;
            font-weight: 700;
            font-size: 1rem !important;
            border: 1px solid #ced4da !important;
        }
    </style>
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
    @stack('styles')
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div id="loading">
        <div id="loading-content">
            <div class="overlay" style="display: none;">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('user.dashboard') }}" class="nav-link">{{ __('app.welcome') }}:
                        {{ auth('web')->user()->name }}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{config('localization.locales')[config('app.locale')]}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @foreach (config('localization.locales') as $key => $locale)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('localization', ['locale' => $key])}}" class="dropdown-item">
                            {{$locale}}
                        </a>
                        @endforeach
                    </div>
                </li> --}}
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $profile_image }}" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">
                            @auth{{ Auth::user()->name }}@endauth
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{ $profile_image }}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                @auth
                                    {{ Auth::user()->name }}
                                <p>({{ Auth::user()->username }})</p>
                            @endauth
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('user.profile.change-password') }}">Change Password</a>
                                </div>
                            </div>

                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('user.profile', encrypt(Auth::guard('web')->id())) }}"
                                class="btn btn-default btn-flat">Profile</a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-default btn-flat float-right">Sign out
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('manage.home') }}" class="brand-link">
                <img src="{{ asset('dist/img/logo_old.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ __('app.app_name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    {{-- <x-admin.admin-sidebar-menus :menus="$menus" :first="1" :range="isset($auth_role->range) ? explode(',', $auth_role->range) : []" /> --}}
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{ isset($page_title) ? $page_title : '' }}

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        {{ isset($content) ? $content : '' }}
                    </div>

                </div>

            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
        </aside> --}}
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2023-2024 <a href="https://adminlte.io">{{ __('app.app_name') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('webroot/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('webroot/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script>
        $(".refresh-captcha").on("click", function() {
            $.ajax({
                url: "{{ route('manage.load-captcha') }}",
                method: "GET",
                success: function(captcha) {
                    $('.captcha-image').attr('src', captcha);
                }
            })
        });

        let loader = {
            show: function() {
                document.querySelector('#loading').classList.add('loading');
                document.querySelector('#loading-content').classList.add('loading-content');
                $("#loading-content .overlay").show();
            },
            hide: function() {
                document.querySelector('#loading').classList.remove('loading');
                document.querySelector('#loading-content').classList.remove('loading-content');
                $("#loading-content .overlay").hide();
            }
        };

        /**
         * Show spinner
         * NOTE: css is defined in resources/sass
         * This file is compiled via webmix
         */

        $(document).ajaxStart(function() {
            loader.show()
        });

        /**
         * Hide spinner
         */

        $(document).ajaxStop(function() {
            loader.hide();
        });
        // $("form").on("submit", function(){
        //     loader.show();
        // });
        setTimeout(function() {
            if (!$(".alert").hasClass('ss-validation')) {
                $(".alert").fadeOut();
            }
        }, 10000);
    </script>
    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('webroot/plugins/fontawesome-free/css/all.min.css') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style type="text/css" media="screen">
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
        }

        .form-signin {
            width: 100%;
            max-width: 450px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .name {
            font-size: 30px;
            line-height: 15px;
            padding-top: 10px;
            font-weight: 700;
            text-align: center;
            margin: 0;
            color: #0d003a;
            font-family: 'Nunito';
        }

        .subhead {
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            color: #06bbcc;
            font-family: 'Nunito';
        }

        .form-group label.error {
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
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('styles')
</head>

<body>
    <div id="loading">
        <div id="loading-content">
            <div class="overlay" style="display: none;">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
        </div>
    </div>
    <div class="form-signin">
        {{ $slot }}
    </div>
    <!-- jQuery -->
    <script src="{{ asset('webroot/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        $(".refresh-captcha").on("click", function() {
            $.ajax({
                url: "{{ route('manage.load-captcha') }}",
                method: "GET",
                success: function(captcha) {
                    $('.captcha-image').attr('src', captcha);
                },
                error: function(jqXHR, exception) {
                    location.reload();
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
    </script>
    @stack('scripts')
</body>

</html>

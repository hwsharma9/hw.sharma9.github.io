<x-user-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Change Password</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-slot>

    <x-slot name="content">
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('CHANGE PASSWORD') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.profile.update-password', ['admin' => auth()->id()]) }}"
                id="quickForm">
                @method('PATCH')
                @csrf
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group">
                                <x-label for="current_password">Current Password <span
                                        class="text-danger">*</span></x-label>
                                <div class="input-group">
                                    <input type="password" name="current_password" class="form-control"
                                        id="current_password" placeholder="Enter Current Password"
                                        value="{{ old('current_password') }}" />
                                    <div class="input-group-append">
                                        <div class="input-group-text" role="button"><i class="far fa-eye-slash"></i>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error name="current_password" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <x-label for="password">New Password <span class="text-danger">*</span></x-label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Enter Password" value="{{ old('password') }}" />
                                    <div class="input-group-append">
                                        <div class="input-group-text" role="button"><i class="far fa-eye-slash"></i>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error name="password" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group" id="pwd-container">
                                <x-label for="password_confirmation">Confirm Password <span
                                        class="text-danger">*</span></x-label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" placeholder="Enter Confirm Password"
                                        value="{{ old('password_confirmation') }}" />
                                    <div class="input-group-append">
                                        <div class="input-group-text" role="button"><i class="far fa-eye-slash"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="pwstrength_viewport_progress"></div>
                                <x-input-error name="password_confirmation" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
            <div class="callout callout-success mt-2">
                Minimum length of Password should be 6 with 1 capital letter, 1 small letter , 1 number.
            </div>
        </x-admin.container-card>
    </x-slot>
    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/additional-methods.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/pwstrength-bootstrap.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".input-group-text").on('click', function() {
                    let closest_input = $(this).closest(".input-group").find('input');
                    if (closest_input.attr("type") == "text") {
                        closest_input.attr('type', 'password');
                        $(this).find("i").addClass("fa-eye-slash").removeClass("fa-eye");
                    } else {
                        closest_input.attr('type', 'text');
                        $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
                    }
                });
            });

            jQuery(function() {
                jQuery.validator.addMethod("alphanumspace", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9\s]*$/.test(value);
                }, "Please enter character and space only.");

                jQuery.validator.addMethod("passwordptr", function(value, element) {
                    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*?~]{6,}$/
                        .test(value);
                }, "Minimum length of Password should be 6 with 1 capital letter, 1 small letter , 1 number");

                jQuery("#quickForm").validate({
                    rules: {
                        current_password: {
                            required: true,
                            maxlength: 20
                        },
                        password: {
                            required: true,
                            minlength: 6,
                            maxlength: 20,
                            passwordptr: true
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: "#password"
                        },
                        captcha: {
                            required: true
                        }
                    },
                    errorPlacement: function(error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                });
            });

            var CustomFormTool = function() {

                var handlePasswordStrengthChecker = function() {
                    var initialized = false;
                    var input = $("#password_confirmation");

                    input.keydown(function() {
                        if (initialized === false) {
                            // set base options
                            input.pwstrength({
                                common: {
                                    userInputs: input,
                                },
                                rules: {
                                    raisePower: 1.4,
                                    minChar: 6,
                                    verdictKeys: ["Weak", "Normal", "Medium", "Strong", "Very Strong"],
                                    scores: [17, 26, 50, 75, 100],
                                },
                                ui: {
                                    container: "#pwd-container",
                                    showVerdictsInsideProgressBar: true,
                                    viewports: {
                                        progress: ".pwstrength_viewport_progress",
                                    },
                                    showVerdicts: true,
                                }
                            });

                            // add your own rule to calculate the password strength
                            input.pwstrength(
                                "addRule",
                                "demoRule",
                                function(options, word, score) {
                                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*?~]{6,}$/.test(
                                        word) && score;
                                },
                                10,
                                true
                            );

                            // set as initialized 
                            initialized = true;
                        }
                    });
                }

                return {
                    //main function to initiate the module
                    init: function() {
                        handlePasswordStrengthChecker();
                    }
                };
            }();
            jQuery(function() {
                CustomFormTool.init();
            }); //end dom


            // $(document).ready(function(){
            //     $(".progress-bar").insertAfter(".input-group-append");
            // });
        </script>
    @endpush
</x-user-layout>

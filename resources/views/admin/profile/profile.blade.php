<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('webroot/plugins/jcrop/css/jquery.Jcrop.min.css') }}" type="text/css" />
    @endpush
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
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
                {{ __('VIEW PROFILE DETAILS') }}
            </x-slot>

            @if (session('update_profile'))
                <div class="alert alert-warning alert-block" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('update_profile') }}
                </div>
            @endif
            @if (session('profile_updated'))
                <div class="alert alert-success alert-block" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('profile_updated') }}
                </div>
            @endif
            <form method="POST" action="{{ route('manage.profile.update', ['admin' => $admin->id]) }}" id="quickForm">
                @method('PATCH')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="role_id">Role <span class="text-danger">*</span></x-label>
                                <input class="form-control" disabled value="{{ $admin->roles[0]->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="role_id">Userame <span class="text-danger">*</span></x-label>
                                <input class="form-control" disabled value="{{ $admin->username }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="first_name">First Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name', $admin->first_name) }}"
                                    style="width: 100%;" />
                                <x-input-error name="first_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="last_name">Last Name <span class="text-danger">*</span></x-label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name', $admin->last_name) }}"
                                    style="width: 100%;" />
                                <x-input-error name="last_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="designation">Designation <span class="text-danger">*</span></x-label>
                                <input class="form-control" disabled value="{{ $admin->designation->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="email">Email <span class="text-danger">*</span></x-label>
                                <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                    value="{{ old('email', $admin->email) }}" style="width: 100%;" disabled />
                                <x-input-error name="email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="mobile">Mobile Number <span class="text-danger">*</span></x-label>
                                <input type="text" class="form-control" id="mobile"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile', $admin->mobile) }}"
                                    style="width: 100%;" disabled />
                                <x-input-error name="mobile" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="employee_id">Employee ID <span class="text-danger">*</span></x-label>
                                <input type="text" class="form-control" name="employee_id" id="employee_id"
                                    placeholder="Enter employee ID"
                                    value="{{ old('employee_id', $admin->detail->employee_id) }}"
                                    style="width: 100%;" />
                                <x-input-error name="employee_id" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-admin.captcha />
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </x-admin.container-card>
        <div id="otp_verification">&nbsp;</div>
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('EMAIL AND MOBILE VERIFICATION') }}
            </x-slot>

            @if (session('otp_verification'))
                <div class="alert alert-warning alert-block" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('otp_verification') }}
                </div>
            @endif

            @if (session('otp_verified'))
                <div class="alert alert-success alert-block" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('otp_verified') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">UPDATE EMAIL ADDRESS OF</h3>
                        </div>
                        <form method="POST" class="form-horizontal"
                            action="{{ route('manage.profile.verified-otp', ['admin' => $admin->id]) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <x-label for="inputEmail3" class="col-sm-3 col-form-label">Email</x-label>
                                    <div class="col-sm-9">
                                        <div class="form-control">
                                            {{ $admin->email }}
                                            @if (is_null($admin->email_verified_at))
                                                <span class="badge badge-danger float-right">Not Verified</span>
                                            @else
                                                <span class="badge badge-success float-right">Verified</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($email_verification_code)
                                    <div class="form-group row">
                                        <x-label for="inputEmail3" class="col-sm-3 col-form-label">Enter OTP</x-label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="email" value="1">
                                            <input type="text" class="form-control" name="otp"
                                                placeholder="Enter Email OTP">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (is_null($admin->email_verified_at))
                                <div class="card-footer">
                                    @if ($email_verification_code)
                                        <button type="submit" class="btn btn-info" name="verifyotp"
                                            value="verifyotp">Verify</button>
                                    @endif
                                    <button type="submit" class="btn btn-default float-right" name="getemailotp"
                                        value="getemailotp">
                                        @if (!$email_verification_code)
                                            Get OTP
                                        @else
                                            Resend OTP
                                        @endif
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">UPDATE MOBILE NUMBER OF</h3>
                        </div>
                        <form method="POST" class="form-horizontal"
                            action="{{ route('manage.profile.verified-otp', ['admin' => $admin->id]) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <x-label for="inputEmail3" class="col-sm-3 col-form-label">Mobile Number</x-label>
                                    <div class="col-sm-9">
                                        <div class="form-control">
                                            {{ $admin->mobile }}
                                            @if (is_null($admin->mobile_verified_at))
                                                <span class="badge badge-danger float-right">Not Verified</span>
                                            @else
                                                <span class="badge badge-success float-right">Verified</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($mobile_verification_code)
                                    <div class="form-group row">
                                        <x-label for="inputEmail3" class="col-sm-3 col-form-label">Enter OTP</x-label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="mobile" value="1">
                                            <input type="text" class="form-control" name="otp"
                                                placeholder="Enter Mobile OTP">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (is_null($admin->mobile_verified_at))
                                <div class="card-footer">
                                    @if ($mobile_verification_code)
                                        <button type="submit" class="btn btn-info" name="verifyotp"
                                            value="verifyotp">Verify</button>
                                    @endif
                                    <button type="submit" class="btn btn-default float-right" name="getmobileotp"
                                        value="getmobileotp">
                                        @if (!$mobile_verification_code)
                                            Get OTP
                                        @else
                                            Resend OTP
                                        @endif
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </x-admin.container-card>
        <x-admin.container-card>
            <x-slot name="title">
                {{ __('UPLOAD PROFILE IMAGE') }}
            </x-slot>

            @if (session('image_uploaded'))
                <div class="alert alert-warning alert-block" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('image_uploaded') }}
                </div>
            @endif

            <form method="POST" action="{{ route('manage.profile.image-upload', ['admin' => $admin->id]) }}"
                id="quickForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="file" style="width: 100%">Profile Image</x-label>
                                <img src="{{ $profile_image }}" alt="Profile Photo" id="preview"
                                    style="height: 200px;"><br>
                                <input type="file" name="file" id="image_file" class="mt-5"><br>
                                <div id="img-error" class="text-danger">
                                    <x-input-error name="file" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-label for="designation">Image Attributes</x-label>
                                <table class="table">
                                    <tr>
                                        <th>File size</th>
                                        <td><input type="text" readonly id="filesize" name="filesize" /></td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td><input type="text" readonly id="filetype" name="filetype" /></td>
                                    </tr>
                                    <tr>
                                        <th>Image dimension</th>
                                        <td><input type="text" readonly id="filedim" name="filedim" /></td>
                                    </tr>
                                    <tr>
                                        <th>Width</th>
                                        <td><input type="text" readonly id="w" name="w" /></td>
                                    </tr>
                                    <tr>
                                        <th>Height</th>
                                        <td><input type="text" readonly id="h" name="h" /></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/plugins/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('webroot/plugins/jcrop/js/jquery.Jcrop.min.js') }}"></script>
        <script type="text/javascript">
            // convert bytes into friendly format

            function bytesToSize(bytes) {
                var sizes = ['Bytes', 'KB', 'MB'];
                if (bytes == 0) return 'n/a';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
            };
            // check for selected crop region
            function checkForm() {
                if (parseInt($('#w').val())) return true;
                $('#img-error').html('Please select a crop region and then press Upload').show();
                return false;
            };

            // update info by cropping (onChange and onSelect events handler)
            function updateInfo(e) {
                $('#x1').val(e.x);
                $('#y1').val(e.y);
                $('#x2').val(e.x2);
                $('#y2').val(e.y2);
                $('#w').val(e.w);
                $('#h').val(e.h);
            };

            // clear info by cropping (onRelease event handler)
            function clearInfo() {
                $('.info #w').val('');
                $('.info #h').val('');
            };

            $('#image_file').on("change", function(e) {
                fileSelectHandler();
            });

            // Create variables (in this scope) to hold the Jcrop API and image size
            var jcrop_api, boundx, boundy;

            function fileSelectHandler() {
                // get selected file
                var oFile = $('#image_file')[0].files[0];
                // hide all errors
                $('#img-error').hide();
                // check for image type (jpg and png are allowed)
                var rFilter = /^(image\/jpeg|image\/png)$/i;
                if (!rFilter.test(oFile.type)) {
                    $('#img-error').html('Please select a valid image file (jpg and png are allowed)').show();
                    return;
                }
                // check for file size
                if (oFile.size > 250 * 1024) {
                    $('#img-error').html('You have selected too big file, please select a one smaller image file').show();
                    return;
                }
                // preview element
                var oImage = document.getElementById('preview');
                // prepare HTML5 FileReader
                var oReader = new FileReader();
                oReader.onload = function(e) {
                    // e.target.result contains the DataURL which we can use as a source of the image
                    oImage.src = e.target.result;
                    oImage.onload = function() { // onload event handler
                        // display step 2
                        $('.step2').fadeIn(500);
                        // display some basic image info
                        var sResultFileSize = bytesToSize(oFile.size);
                        $('#filesize').val(sResultFileSize);
                        $('#filetype').val(oFile.type);
                        $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
                        // destroy Jcrop if it is existed
                        if (typeof jcrop_api != 'undefined') {
                            jcrop_api.destroy();
                            jcrop_api = null;
                            $('#preview').width(oImage.naturalWidth);
                            $('#preview').height(oImage.naturalHeight);
                        }
                        /// setTimeout(function(){
                        // initialize Jcrop
                        $('#preview').Jcrop({
                            //minSize: [85, 125], // min crop size
                            maxSize: [236, 295],
                            aspectRatio: 236 / 295, // keep aspect ratio 1:1
                            bgFade: true, // use fade effect
                            bgOpacity: .5, // fade opacity
                            onChange: updateInfo,
                            onSelect: updateInfo,
                            onRelease: clearInfo
                        }, function() {
                            // use the Jcrop API to get the real image size
                            var bounds = this.getBounds();
                            boundx = bounds[0];
                            boundy = bounds[1];
                            // Store the Jcrop API in the jcrop_api variable
                            jcrop_api = this;
                        });


                        jcrop_api.setSelect([0, 0, 213, 267]);
                        // },500);
                    };
                };
                // read selected file as DataURL
                oReader.readAsDataURL(oFile);
            }
        </script>
    @endpush
</x-admin-layout>

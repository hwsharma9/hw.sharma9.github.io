<x-admin-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Unauthorize') }}</li>
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="container py-5">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br />Status Code: 403</p>
                            </div>
                            <div class="col-md-10">
                                <h3>OPPSSS!!!! Sorry...</h3>
                                <p>Sorry, your access is refused due to security reasons of our server and also our
                                    sensitive data.<br />Please go back to the previous page to continue browsing.</p>
                                <a class="btn btn-danger" href="javascript:history.back()">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>

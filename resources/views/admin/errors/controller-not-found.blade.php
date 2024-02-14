<x-admin-layout>
    <x-slot name="page_title">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Controller Not Found') }}</li>
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
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br />Status Code: 404</p>
                            </div>
                            @php
                                $controller_name = $db_controller_route->db_controller->controller_name;
                            @endphp
                            <div class="col-md-10">
                                <h3>OPPSSS!!!! Sorry...</h3>
                                <h4>Controller not found.</h4>
                                <h5>To create controller follow the commands...</h5>
                                <p>Open Terminal following the project folder and run the following commands</p>
                                <p><strong>php artisan make:controller manage\{{ $controller_name }} -r</strong></p>

                                <p>Recommended command</p>
                                <p><strong>php artisan make:model {{ $controller_name }} -mcrR</strong></p>
                                <p>m => migrations</p>
                                <p>c => controller (Note - But it creates the controller in route So move it into manage
                                    folder.)</p>
                                <p>r => resourse controller with (index, create, store, edit, update and destroy
                                    functions)</p>
                                <p>R => Request Files (Validation Files) resides at app/Http/Requests</p>
                                <a class="btn btn-danger" href="javascript:history.back()">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>

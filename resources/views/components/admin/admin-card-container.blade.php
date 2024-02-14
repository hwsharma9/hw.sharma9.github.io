<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title m-0">
                        {{ $titlle }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ $slot }}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

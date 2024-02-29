<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title m-0 text-uppercase">
                        {{ $title }}
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool bg-info" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div>
                    @if ($showmessage)
                        <x-flash-message />
                        <x-auth-validation-errors />
                    @endif
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

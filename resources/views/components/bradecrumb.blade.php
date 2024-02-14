<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('manage.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ __('Database Controllers & Routes') }}</li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">View</a></li>
                </ol>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    @if (Gate::allows('check-auth', 'manage.dbcontrollers.create'))
                        <a href="{{ route('manage.dbcontrollers.create') }}" class="btn btn-primary"><i
                                class="fa fa-plus"></i> Add</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@props(['errors'])

@if ($errors->any())
    <div class="mt-3 ml-3 mr-3">
        <div class="alert alert-danger alert-block ss-validation">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <div {{ $attributes }}>
                <div class="fs-5">
                    {{ __('Something went wrong.') }}
                </div>

                <ul class="mt-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

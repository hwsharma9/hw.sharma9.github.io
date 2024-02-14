<x-admin-layout>
    @push('styles')
        <style>
            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 70px;
                padding: 0 10px;
                margin-bottom: 10px;
            }

            .img-bg {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                position: relative;
                padding-bottom: 100%;
            }

            .upload-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid gray;
                margin-top: 1px;
                padding-left: 2px;
                padding-right: 2px;
            }
        </style>
    @endpush
    <x-slot name="page_title">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{ __('Course Remark') }}</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
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
                {{ __('Add Course Remark') }}
            </x-slot>

            <form method="POST" action="{{ route('manage.course.remark.create', ['course' => $course->id]) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-label for="remark">Remark</x-label>
                            <textarea name="remark" cols="30" rows="10" class="form-control">{{ old('remark') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-admin.captcha />
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <span>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </span>
                </div>
            </form>
        </x-admin.container-card>
    </x-slot>
</x-admin-layout>

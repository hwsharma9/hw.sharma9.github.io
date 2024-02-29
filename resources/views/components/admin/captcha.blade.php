<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <x-label for="captcha" style="width: 100%;">Security Code <span class="text-danger">*</span></x-label>
            <input type="text" name="captcha" id="captcha" class="form-control @error('captcha') is-invalid @enderror"
                placeholder="Enter Security Code" value="" style="width: 100%;" />
            <x-input-error name="captcha" />
        </div>
        <div class="col-md-6" style="margin-top:25px;">
            <img src="{{ Captcha::src('default') }}" class="captcha-image"> <a href="javascript:void(0)"
                class="refresh-captcha"><i class="fas fa-sync-alt"></i></a>
        </div>
    </div>
</div>

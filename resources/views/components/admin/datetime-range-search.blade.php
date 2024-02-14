@props(['label', 'name'])
<div class="form-group">
    <label>{{ $label }}</label>

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-clock"></i></span>
        </div>
        <input type="text" name="{{ $name }}" class="form-control float-right" id="{{ $name }}"
            autocomplete="off">
    </div>
</div>

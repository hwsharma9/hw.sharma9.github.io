@if (array_key_exists('create', $actions))
    <button class="btn btn-success" title="Create Form">Create</button>
@endif
@if (array_key_exists('update', $actions))
    <button class="btn btn-success" title="Update Form">Update</button>
@endif
@if (array_key_exists('create_back', $actions))
    <button type="submit" class="btn btn-primary" name="action" value="{{ $actions['create_back'] }}">Create and
        New</button>
@endif
@if (array_key_exists('update_back', $actions))
    <button type="submit" class="btn btn-primary" name="action" value="{{ $actions['update_back'] }}">Update and
        Back</button>
@endif
{{-- @if (array_key_exists('clear', $actions))
<button type="reset" class="btn btn-secondary">Clear</button>
@endif --}}
@if (array_key_exists('back', $actions))
    <a href="{{ $actions['back'] }}" class="btn btn-secondary">Back</a>
@endif
{{-- @if (array_key_exists('extra', $actions))
    @if (is_array($actions['extra']))
        {!! implode('', $actions['extra']) !!}
    @else
        {!! $actions['extra'] !!}
    @endif
@endif --}}

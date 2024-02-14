@php
    $edit_permission = false;
    if (array_key_exists('edit', $actions)) {
        $edit_permission = isset($permissions['edit']) ? $permissions['edit'] : Gate::allows('check-auth', $actions['edit']);
    }
    $show_permission = false;
    if (array_key_exists('show', $actions)) {
        $show_permission = isset($permissions['show']) ? $permissions['show'] : Gate::allows('check-auth', $actions['show']);
    }
    $delete_permission = false;
    if (array_key_exists('delete', $actions)) {
        $delete_permission = isset($permissions['delete']) ? $permissions['delete'] : Gate::allows('check-auth', $actions['delete']);
    }
    $id = gettype($model) == 'object' ? $model->id : $model['id'];
@endphp
<div class="d-flex felx-row justify-content-around">
    @if (array_key_exists('edit', $actions))
        @if ($edit_permission)
            <a class="btn btn-primary" title="Edit Model"
                href="{{ route($actions['edit'], isset($encrypt) && $encrypt == 1 ? encrypt($id) : $id) }}"><i
                    class="fas fa-edit"></i></a>
        @endif
    @endif
    @if (array_key_exists('show', $actions))
        @if ($show_permission)
            <a class="btn btn-secondary" title="View Model"
                href="{{ route($actions['show'], isset($encrypt) && $encrypt == 1 ? encrypt($id) : $id) }}"><i
                    class="fas fa-eye"></i></a>
        @endif
    @endif
    {{-- @if (array_key_exists('delete', $actions))
        @if ($delete_permission)
            <form action="{{route($actions['delete'], $id)}}" method="POST" class="delete-model">
                @method('DELETE')
                @csrf
                @if (!is_null($model['deleted_at']))
                    <input type="hidden" name="restore" value="1">
                    <button class="btn btn-success" title="Restore Model" type="submit"><i class="fas fa-trash-restore"></i></button>
                @else
                    <button class="btn btn-danger" title="Delete Model" type="submit"><i class="fas fa-trash"></i></button>
                @endif
            </form>
        @endif
    @endif --}}
    {{-- @if (array_key_exists('extra', $actions))
        @if (is_array($actions['extra']))
            {!! implode('', $actions['extra']) !!}
        @else
            {!! $actions['extra'] !!}
        @endif
    @endif --}}
</div>

<ul>
    @foreach ($menus as $menu)
        @php
            $children = isset($menu->children) ? $menu->children : (object) [];
            $c_collect = collect($children);
        @endphp
        <li data-id="{{ $menu->id }}">
            <input type="checkbox" value="{{ $menu->id }}" name="range[]"
                @if (in_array($menu->id, $role)) checked="checked" @endif />
            {{ $menu->menu_name }}
            @if ($c_collect->count() > 0)
                @include('components\admin\admin-menu-tree-checkbox', [
                    'menus' => $c_collect,
                    'role' => $role,
                ])
            @endif
        </li>
    @endforeach
</ul>

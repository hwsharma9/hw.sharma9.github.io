<ol class="{{ $class }}">
    @foreach ($menus as $menu)
        @php
            $c_collect = collect(isset($menu->children) ? $menu->children : (object) []);
        @endphp
        <li class="dd-item dd3-item" data-id="{{ $menu->id }}">
            <div class="dd-handle dd3-handle"></div>
            <div class="dd3-content">
                <span id="label_show-{{ $menu->id }}">{{ $menu->title_en }}</span>
                <span class="span-right">
                    <span id="link_show{{ $menu->id }}">
                    </span>
                    <a class="btn btn-xs btn-primary edit-button modify_{{ $menu->id }}" id="menu-{{ $menu->id }}"
                        data-menu="{{ collect($menu)->toJson() }}"
                        href="{{ route('manage.frontmenus.edit', ['frontmenu' => $menu->id]) }}">
                        <i class=" fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-xs btn-danger del-button" id="{{ $menu->id }}"
                        data-delete-route="{{ route('manage.frontmenus.destroy', ['frontmenu' => $menu->id]) }}"><i
                            class="fas fa-trash"></i></a>
                </span>
            </div>
            @if ($c_collect->count() > 0)
                <x-admin.front-menu-tree :menus="$c_collect" class="child" />
            @endif
        </li>
    @endforeach
</ol>

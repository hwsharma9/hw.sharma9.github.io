@if ($menus)
    @foreach ($menus as $menu)
        @php
            $url = route('root.dashboard.index');
            if ($menu->menu_type == 1 && $menu->page && $menu->db_controller_route) {
                $url = route('root.' . $menu->db_controller_route->named_route, $menu->page->slug);
            } elseif ($menu->menu_type == 2 && $menu->db_controller_route) {
                $url = route('root.' . $menu->db_controller_route->named_route);
            } else {
                $url = $menu->custom_url;
            }
        @endphp
        <a class="btn btn-link" href="{{ $url }}">{{ $menu->title_en }}</a>
    @endforeach
@endif

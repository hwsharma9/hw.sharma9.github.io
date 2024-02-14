<div class="c-navbar__links js-navbar-links ">
    <ul class="@if ($first == 1) c-navbar__list @else c-navbar__dropdown-list @endif">
        @if ($menus)
            @foreach ($menus as $menu)
                @php
                    $children = isset($menu->children) ? $menu->children : (object) [];
                    $c_collect = collect($children);
                @endphp
                <li
                    class="@if ($first == 1) c-navbar__item c-navbar__item--dropdown @else c-navbar__dropdown-item @endif">
                    @if ($c_collect->count() > 0)
                        <button class="c-navbar__link ">
                            {{ $menu->title_en }}
                            <svg class="c-navbar__link-icon" viewbox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.217 8.502l1.435-1.435L12 15.415l8.348-8.348L21.783 8.5 12 18.284 2.217 8.501z" />
                            </svg>
                        </button>
                        <div class="c-navbar__dropdown">
                            <div class="c-navbar__dropdown-wrapper">
                                <x-front.menus :menus="$c_collect" :first="0" />
                            </div>
                        </div>
                    @else
                        @php
                            $url = route('root.dashboard.index');
                            // echo $menu->menu_type;
                            // print_r($menu->page);
                            // var_dump($menu->db_controller_route);
                            if ($menu->menu_type == 1 && $menu->page && $menu->db_controller_route) {
                                $url = route('root.' . $menu->db_controller_route->named_route, $menu->page->slug);
                            } elseif ($menu->menu_type == 2 && $menu->db_controller_route) {
                                // print_r($menu->db_controller_route->named_route);
                                $url = route('root.' . $menu->db_controller_route->named_route);
                            } else {
                                $url = $menu->custom_url;
                            }
                        @endphp
                        @if ($first == 1)
                            <a href="{{ $url }}" {{ $menu->open_same_tab == 1 ? 'target="_blank"' : '' }}
                                class="c-navbar__link">
                                {{ $menu->title_en }}
                            </a>
                        @else
                            <a href="{{ $url }}" {{ $menu->open_same_tab == 1 ? 'target="_blank"' : '' }}
                                class="c-navbar__dropdown-link">
                                {{ $menu->title_en }}
                            </a>
                        @endif
                    @endif
                </li>
            @endforeach
        @endif

        <div class="c-navbar__menu-container">
            <button class="c-navbar__menu" id="js-navbar-menu-toggle" aria-controls="js-navbar-links">
                <span>
                    <span class="u-visually-hide"></span>
                </span>
            </button>
        </div>
        {{-- <li class="c-navbar__item c-navbar__item--dropdown">
            <a href="index.html" class="c-navbar__link active" style="color:#06bbcc">Home</a>
        </li>
        <li class="c-navbar__item c-navbar__item--dropdown">
            <a href="{{route('root.page.show', ['page' => 'about-us'])}}" class="c-navbar__link ">About</a>
        </li>             
        <li class="c-navbar__item c-navbar__item--dropdown">
            <button class="c-navbar__link ">
                Courses
                <svg class="c-navbar__link-icon" viewbox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.217 8.502l1.435-1.435L12 15.415l8.348-8.348L21.783 8.5 12 18.284 2.217 8.501z" />
                </svg>
            </button>
            <div class="c-navbar__dropdown">
                <div class="c-navbar__dropdown-wrapper">
                    <ul class="c-navbar__dropdown-list">
                        <li class="c-navbar__dropdown-item">
                            <a href="#" class="c-navbar__dropdown-link">
                                <span>MAP_IT - TCU (29)</span>
                                <span>Creating the most effective learning experience</span>
                            </a>
                        </li>
                        <li class="c-navbar__dropdown-item">
                            <a href="#" class="c-navbar__dropdown-link">
                                <span>Skill Development (40)</span>
                                <span>Creating the most effective learning experience</span>
                            </a>
                        </li>
                        <li class="c-navbar__dropdown-item">
                            <a href="#" class="c-navbar__dropdown-link">
                                <span>Police Head Quarters (53)</span>
                                <span>Creating the most effective learning experience</span>
                            </a>
                        </li>
                        <li class="c-navbar__dropdown-item">
                            <a href="#" class="c-navbar__dropdown-link">
                                <span>MPRRDA (24)</span>
                                <span>Creating the most effective learning experience</span>
                            </a>
                        </li>
                        
                        <li class="c-navbar__dropdown-item">
                            <a href="#" class="c-navbar__dropdown-link">
                                <span>2nd Dropdown</span>
                                <span>Results from some of the companies using eduMe</span>
                                <svg class="" viewbox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.502 21.783l-1.435-1.435L15.415 12 7.067 3.652 8.5 2.217 18.284 12l-9.782 9.784z" />
                                </svg>
                            </a>
                        
                            <div class="c-navbar__dropdown-sub">
                                <div class="c-navbar__dropdown-sub-wrapper">
                                    <ul class="c-navbar__dropdown-sub-list">
                                        <li class="c-navbar__dropdown-sub-item">
                                            <a href="#" class="c-navbar__dropdown-sub-link">
                                                <span>menu 123</span>
                                                <span>79% training engagement rate</span>
                                            </a>
                                        </li>
                                        <li class="c-navbar__dropdown-sub-item">
                                            <a href="#" class="c-navbar__dropdown-sub-link">
                                                <span>Menu 1234</span>
                                                <span>Onboarding time reduced by 13%</span>
                                            </a>
                                        </li>
                                        <li class="c-navbar__dropdown-sub-item">
                                            <a href="#" class="c-navbar__dropdown-sub-link">
                                                <span>Menu 12345</span>
                                                <span>70% reduction in time to productivity</span>
                                            </a>
                                        </li>
                                        <li class="c-navbar__dropdown-sub-item">
                                            <a href="#" class="c-navbar__dropdown-sub-link">
                                                <span>Menu 123456</span>
                                                <span>Onboarding time reduced by over 50%</span>
                                            </a>
                                        </li>
                                        <li class="c-navbar__dropdown-sub-item">
                                            <a href="#" class="c-navbar__dropdown-sub-link">
                                                <span>Menu 1234567</span>
                                                <span>99% reduction in time to productivity</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>      
        </li>
        <li class="c-navbar__item c-navbar__item--dropdown">
            <a href="#" class="c-navbar__link ">Download</a>
        </li> 
        <li class="c-navbar__item c-navbar__item--dropdown">
        <a href="#" class="c-navbar__link ">Videos</a>
        </li> 
        <li class="c-navbar__item c-navbar__item--dropdown">
            <a href="#" class="c-navbar__link ">Contact</a>
        </li> --}}
    </ul>
</div>

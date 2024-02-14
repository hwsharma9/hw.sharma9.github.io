<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge text-bold">{{ $unread_notifications->count() }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ $unread_notifications->count() }}
            Notifications</span>
        <div class="dropdown-divider"></div>
        {!! $notifications_html->implode('') !!}
    </div>
</li>

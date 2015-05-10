<section class="sidebar">
    <ul class="sidebar-menu">
        <!-- <li class="header">HEADER</li> -->
        @foreach ($menu as $menuItem)
            <li class="{!! $menuItem['isActive'] ? 'active' : '' !!}">
                <a href="{!! $menuItem['link'] !!}">
                    <i class="fa fa-{!! $menuItem['icon'] or '' !!}"></i>
                    <span>{!! $menuItem['title'] !!}</span>
                </a>
            </li>
        @endforeach
    </ul>
</section>
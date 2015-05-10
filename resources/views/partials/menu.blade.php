@if (! $menu->isEmpty())

<div class="navbar-collapse collapse">
    <ul id="" class="nav navbar-nav navbar-right">
        @foreach($menu as $menuItem)
            <li class="{!! $menuItem['isActive'] ? 'active' : '' !!}">
                <a href="{!! $menuItem['link'] !!}">{!! $menuItem['title'] !!}</a>
            </li>
        @endforeach
    </ul>
</div> <!-- /.nav-collapse -->

@endif

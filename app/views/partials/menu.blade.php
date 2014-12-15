@if (! $menu->isEmpty())

<div class="navbar-collapse collapse">
    <ul id="" class="nav navbar-nav navbar-right">
    @foreach($menu->all() as $name => $attr)

        @if(is_array($attr))

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{ ucwords(preg_replace('/\_|\-/', ' ', $name)) }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">

            @foreach($attr['items'] as $name => $link)

            <li>
                <a href="{{ $link }}">{{ ucwords(preg_replace('/\_|\-/', ' ', $name)) }}</a>
            </li>

            @endforeach

            </ul>
        </li>

        @else

        <li {{ URL::current() === $attr ? 'class="active"' : '' }}>
            <a href="{{ $attr }}">
                {{ ucwords(preg_replace('/\_|\-/', ' ', $name)) }}
            </a>
        </li>

        @endif
    @endforeach
    </ul>
</div><!--/.nav-collapse -->

@endif
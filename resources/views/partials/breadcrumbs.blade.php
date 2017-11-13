@if ($breadcrumbs)
    <ul class="nav navbar-nav navbar-left">
        @foreach ($breadcrumbs as $i => $breadcrumb)
            @if ($breadcrumbs->count() !== $i + 1)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                <li class="separator hidden-xs">|</li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif

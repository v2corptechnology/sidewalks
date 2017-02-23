<!-- Left Side Of Navbar -->
@if (auth()->user()->hasShop())
    <li>
        <a href="{{ route('shops.show', auth()->user()->shop) }}">My shop</a>
    </li>
    <li>
        <a href="{{ route('items.create') }}">Create item</a>
    </li>

    @if (auth()->user()->email == 'romain.sauvaire@gmail.com')
        <li>
            <a href="{{ route('paths.show', 1) }}">Paths</a>
        </li>
    @endif

    <li class="hidden">
        <a href="{{ route('crawls.create') }}">Crawl website</a>
    </li>
@else
    <li>
        <a href="{{ route('shops.create') }}">Create my shop</a>
    </li>
@endif
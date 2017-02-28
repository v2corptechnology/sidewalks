<!-- Left Side Of Navbar -->
@if (auth()->user()->hasShop())
    <li>
        <a href="{{ route('shops.show', auth()->user()->shop) }}">My shop</a>
    </li>
    <li>
        <a href="{{ route('items.create') }}">Create item</a>
    </li>
@else
    <li>
        <a href="{{ route('shops.create') }}">Create my shop</a>
    </li>
@endif

<li>
    <a href="{{ route('paths.index') }}">Paths</a>
</li>

<li class="hidden">
    <a href="{{ route('crawls.create') }}">Crawl website</a>
</li>
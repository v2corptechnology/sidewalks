<div class="thumbnail">
    <a href="{{ route('items.show', $item) }}">
        <img class="img-responsive" src="{{ asset("storage/items/originals/{$item->id}/{$item->images[0]}") }}" alt="{{ $item->title }}">
        <div class="caption">
            <h4>{{ $item->title }}</h4>
            <p>{{ $item->description }}</p>
        </div>
    </a>    
</div>
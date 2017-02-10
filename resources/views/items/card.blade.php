<div class="item box" data-item-id="{{ $item->id }}">
	<a class="item__content" href="{{ route('items.show', $item) }}" title="{{ $item->description }}">
	    <figure class="item__gallery">
	        <img class="item__image img-responsive" 
	        	 alt="{{ $item->title }}" 
	        	 src="{{ $item->coverImage('400x300') }}" 
	        	 srcset="{{ $item->coverImage('400x300@2x') }} 2x" 
	        	 itemprop="image" width="400" height="300">
	        <figcaption class="item__title">
	            <span class="item__price">${{ $item->amount }}</span>
	            {{ $item->title }}
	        </figcaption>
	    </figure>
	</a>
</div>
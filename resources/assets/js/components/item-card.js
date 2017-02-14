Vue.component('item-card', {
	props: ['item'],
	template: `
	<div class="col-sm-3">
	    <div class="item box">
	        <a class="item__content" :href="item.display_url" :title="item.description">
	            <figure class="item__gallery">
	                <img class="item__image img-responsive" 
	                     :alt="item.title" 
	                     :src="item.src" 
	                     :srcset="item.srcset" 
	                     itemprop="image" width="400" height="300">
	                <figcaption class="item__title">
	                    <span class="item__price">{{ "$" + item.amount }}</span>
	                    {{ item.title }}
	                </figcaption>
	            </figure>
	        </a>
	    </div>
	</div>
	`,
});
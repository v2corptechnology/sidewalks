Vue.component('shop-items', {
	props: ['rawItems'],
	template: `
		<div>
            <form action="#" class="form-inline pull-right">
                <label class="control-label" for="filter">
                    <input class="form-control input-sm" type="search" name="filter" id="filter" placeholder="Filter...">
                </label>
            </form>
            <h1 class="h3">{{ items.length }} items</h1>
            <div class="row">
            	<item-card v-for="item in items" :item="item"></item-card>
            </div>
        </div>
	`,
	data() {
		return {
			items: [],
		};
	},
	mounted() {
		this.fetchData();
	},
	methods: {
		fetchData() {
			// Use AJAX call
			this.items = JSON.parse(this.rawItems);
		}
	}
});
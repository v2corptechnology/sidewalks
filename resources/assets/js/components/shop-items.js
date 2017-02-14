Vue.component('shop-items', {
	props: ['rawItems'],
	template: `
		<div>
            <form action="#" class="form-inline pull-right">
                <label class="control-label" for="filter">
                    <input class="form-control input-sm" type="search" name="filter" id="filter" placeholder="Filter..." v-model="filterString">
                </label>
            </form>
            <h1 class="h3">{{ items.length }} items</h1>
            <div class="row">
            	<item-card v-for="item in filteredItems" :item="item"></item-card>
            </div>
        </div>
	`,
	data() {
		return {
			items: [],
			filterString: null,
		};
	},
	computed: {
		filteredItems() {
			var data = this.items,
				filterString = this.filterString && this.filterString.toLowerCase();

			if (filterString) {
				data = this.items.filter(function (row) {
					return Object.keys(row).some(function (key) {
						return String(row[key]).toLowerCase().indexOf(filterString) > -1
					})
				})
			}

			return data;
		}
	},
	created() {
		this.fetchData();
	},
	methods: {
		fetchData() {
			// Use AJAX call
			this.items = JSON.parse(this.rawItems);
		}
	}
});
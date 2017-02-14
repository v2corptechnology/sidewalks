Vue.component('shop-items', {
	props: ['rawItems'],
	template: `
		<div>
            <form action="#" class="form-inline pull-right">
                <label class="control-label" for="filter">
                    <input class="form-control input-sm" type="search" name="filter" id="filter" placeholder="Filter..." v-model="filterString">
                </label>
            </form>
            <h1 class="h3">{{ filteredItems.length }} items</h1>
            <div class="row">
            	<item-card v-for="item in filteredItems" :item="item"></item-card>
            </div>
        </div>
	`,
	data() {
		return {
			items: [],
			filterString: null,
			hasToEmit: false,
		};
	},
	computed: {
		filteredItems() {
			var data = this.items,
				filterString = this.filterString && this.filterString.toLowerCase();

			if (filterString) {
				if (filterString.indexOf('id: ') > -1) {
					data = this.items.filter(function (item) {
						return item.id == filterString.substring(3);
					})
				} else {
					data = this.items.filter(function (item) {
						return Object.keys(item).some(function (key) {
							return String(item[key]).toLowerCase().indexOf(filterString) > -1
						})
					})
				}
			}

			if (this.hasToEmit && data.length == 1) {
				Bus.$emit('item-isolated', data[0]);
				this.hasToEmit = false;
			}

			if (data.length > 1 && ! this.hasToEmit) {
				this.hasToEmit = true;
			}

			return data;
		}
	},
	created() {
		this.fetchData();
		Bus.$on('marker-selected', this.onMarkerSelected);
		Bus.$on('marker-unselected', this.onMarkerUnselected);
	},
	methods: {
		fetchData() {
			// Use AJAX call
			this.items = JSON.parse(this.rawItems);
			this.hasToEmit = this.items.length > 1;
		},
		onMarkerSelected(marker) {
			this.filterString = 'Id: ' + marker.id;
		},
		onMarkerUnselected(marker) {
			this.filterString = null;
		}
	}
});
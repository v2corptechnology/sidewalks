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
                if (filterString.indexOf('items: ') > -1) {
                    data = this.items.filter(function (item) {
                        return item.id == filterString.substring(6);
                    })
                } else if (filterString.indexOf('categories: ') > -1) {
                    data = this.items.filter(function (item) {
                        return item.categories.some(function (category) {
                            return category.id == filterString.substring(11);
                        });
                    });
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
            this.filterString = marker.filter;
        },
        onMarkerUnselected(marker) {
            this.filterString = null;
        }
    }
});
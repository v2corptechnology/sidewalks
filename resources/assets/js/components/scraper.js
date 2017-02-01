Vue.component('scraper', {
    template: `
            <fieldset :disabled="isScraping">
                <label class="control-label" for="scrape-url">
                    Import from website or search our database 
                    <span v-show="count">({{ count }} results)</span>
                </label>
                <div class="input-group">
                    <input class="form-control" type="url" name="url" id="scrape-url" placeholder="Url or name of your item"
                           v-model="query" @click="selectAll" @keyup="search">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" @click="scrape" :disabled="!isValidUrl">
                            <i v-bind:class="[isScraping ? 'fa-spinner fa-spin' : 'fa-cloud-download', 'fa fa-fw']" aria-hidden="true"></i> Fetch
                        </button>
                    </span>
                </div>
                <div class="media" v-for="result in results">
                    <div class="media-left">
                        <img class="media-object" :src="result.imageUrl" alt="" width="50"/>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">{{ result.title }}</h5>
                        <p>
                            Price: <b>{{ result.minSalePrice }} ~ {{ result.maxSalePrice }}</b>
                        </p>
                        <hr />
                    </div>
                    <div class="media-right">
                        <button class="btn btn-sm btn-primary" @click="onItemSelected(result)">Select</button>
                    </div>
                </div>
            </fieldset>
    `,

    data() {
        return {
            query: null,
            isScraping: false,
            count: null,
            results: [],
        };
    },

    /*watch: {
        query() {
            this.results = [];
            this.count = null;
        }
    },*/

    computed: {
        isValidUrl() {
            var urlPattern = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
            return urlPattern.test(this.query);
        }
    },

    methods: {

        selectAll(event) {
            event.target.select();
        },

        search() {
            if (! this.isValidUrl && this.query.length) {
                this.autocomplete();
            }
        },

        autocomplete: _.debounce(function () {
            this.$http.get('/autocomplete', {params: {q: this.query}})
                .then(response => {
                    this.count = response.data.result.count;
                    this.results = response.data.result.products;
                });
        }, 300),

        scrape() {
            this.isScraping = true;

            this.$http.post('/scrape', {url: encodeURIComponent(this.query)})
                .then(response => {
                    response.data.scrapedUrl = this.query;

                    this.$emit('scraped', response.data);

                    this.isScraping = false;
                    this.query = null;
                }, (response) => {
                    this.isScraping = false;
                });
        },

        onItemSelected(item) {
            this.$emit('scraped', {
                amount: item.minSalePrice,
                title: item.title,
                quantity: 1,
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                images: [item.imageUrl],
            });
            this.results = [];
            this.count = null;
            this.query = null;
        }
    }
});

Vue.component('marker-attach', {
    props: ['raw-categories', 'raw-items'],
    template: `
        <fieldset :disabled="! canBeSaved">
            <div class="form-group">
                <select class="form-control js-link_to" name="link_to" required :disabled="! currentMarker">
                    <option value="">Choose</option>
                    <optgroup label="Categories">
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </optgroup>
                    <optgroup label="Items">
                        <option v-for="item in items" :value="item.id">{{ item.title }}</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" @click="onSubmit">Save marker</button>
            </div>
        </fieldset>
    `,
    data() {
        return {
            currentMarker: null,
            canBeSaved: false,
        };
    },
    computed: {
        items() {
            return JSON.parse(this.rawItems);
        },
        categories() {
            return JSON.parse(this.rawCategories);
        }
    },
    created() {
        Bus.$on('marker-created', this.onMarkerCreated);
        Bus.$on('maker-associated', this.onMarkerAssociated);
    },
    methods: {
        onMarkerCreated(marker) {
            this.currentMarker = marker;
        },
        onSubmit() {
            /* TODO: URGENT REFACTOR NEEDED */
            var selectedOption = $('.js-link_to option:selected');
            this.currentMarker.item_id = selectedOption.val();
            
            var targetUrl = window.location.pathname.substring( 0, window.location.pathname.indexOf( "/create" ) );

            this.$http.post(targetUrl, {
                item_id: this.currentMarker.item_id, 
                latitude: this.currentMarker.latitude, 
                longitude: this.currentMarker.longitude,
                latitude_px: this.currentMarker.y,
                longitude_px: this.currentMarker.x,
            }).then(response => {
                this.currentMarker.tooltip = selectedOption.text();
                Bus.$emit('marker-saved', this.currentMarker);
                this.canBeSaved = false;
                this.currentMarker = null;
            }, (response) => {
                alert('error');
            });
        },
        onMarkerAssociated() {
            this.canBeSaved = true;
        }
    },
});
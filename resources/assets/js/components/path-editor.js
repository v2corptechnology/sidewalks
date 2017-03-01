Vue.component('path-editor', {
    props: ['pathId', 'panoramaId'],
    template: `
        <div>
            <p class="help-block" v-if="!markers.length">First click where you want to link another view.</p>
            <div class="media" v-for="marker in markers">
                <div class="media-left">
                    <i class="media-object fa fa-arrow-circle-up fa-fw fa-2x" :style="{ color: marker.color }"></i>
                </div>
                <div class="media-body">
                    <div class="form-group">
                        <div v-if="marker.markable && marker.markable.imageUrl">
                            <a :href="marker.markable.urls.edit">
                                <img class="img-responsive" :src="marker.markable.imageUrl" alt="" />
                            </a>
                        </div>
                        <view-uploader v-else :path-id="pathId" :panorama-id="panoramaId" :marker="marker"></view-uploader>
                    </div>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            markers: [],
        };
    },
    created() {
        Bus.$on('marker-created', this.onMarkerCreated);
        Bus.$on('marker-removed', this.onMarkerRemoved);

        // Get view info
        this.$http.get('/api/views/' + this.panoramaId)
            .then(response => {
                this.markers = response.data.markers;
            })
            .catch(error => {
                console.log(error);
                alert('Error while fetching markers');
            });
    },
    methods: {
        onMarkerCreated(marker) {
            this.markers.push(marker);
        },
        onMarkerRemoved(marker) {
            alert('do something when marker is removed');
        }
    }
});
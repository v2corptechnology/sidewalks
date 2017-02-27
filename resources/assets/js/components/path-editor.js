Vue.component('path-editor', {
    template: `
        <div>
            <p class="help-block" v-if="!markers.length">First click where you want to link another view.</p>
            <div class="media" v-for="marker in markers">
                <div class="media-left">
                    <i class="media-object fa fa-arrow-circle-up fa-fw fa-2x" :style="{ color: marker.color }"></i>
                </div>
                <div class="media-body">
                    <div class="form-group">
                        <view-uploader></view-uploader>
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
import randomColor from 'randomcolor';

Vue.component('panoramas-creator', {
    props: {
        path: {type: Object, required: true},
        panorama: {type: Object, required: true},
        markers: {type: Array, required: true, default: []}, 
    },
    template: `
        <div>
            <p class="help-block" v-if="!markerList.length">First click where you want to link another view.</p>
            <div class="media" v-for="marker in markerList">
                <div class="media-left">
                    <i class="media-object fa fa-arrow-circle-up fa-fw fa-2x" :style="{ color: marker.color }"></i>
                </div>
                <div class="media-body">
                    <div class="form-group">
                        <div v-if="isValidMarker(marker)">
                            <a :href="getMarkerInfo(marker).urls.edit">
                                <img class="img-responsive" :src="getMarkerInfo(marker).imageUrl" :alt="marker.id" />
                            </a>
                        </div>
                        <view-uploader v-else :path-id="path.id" :panorama-id="panorama.id" :marker="marker"></view-uploader>
                    </div>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            createdId: null,
            markerList: this.markers,
        };
    },
    created() {
        Bus.$on('panorama-click', this.onPanoramaClick);
        Bus.$on('panorama-hover', this.onPanoramaHover);
        Bus.$on('panorama-leave', this.onPanoramaLeave);
        Bus.$on('view-uploader-uploaded', this.onViewUploaderUploaded);
    },
    methods: {
        isValidMarker(marker) {
            return marker.id != this.createdId;
        },
        getMarkerInfo(marker) {
            return marker.markable || marker;
        },
        onViewUploaderUploaded(marker) {
            this.markerList.splice(0, 1, Object.assign(this.markerList[0], marker));
            this.createdId = null;
        },
        onPanoramaHover(markerId) {

        },
        onPanoramaLeave(markerId) {

        },
        onPanoramaClick(event) {
            if (this.createdId) {
                Bus.$emit('panorama-marker-removed', this.createdId);
                this.markerList.shift();
                this.createdId = null;
            }

            this.createdId = Math.random().toString(36).substr(2, 5);

            var randomcolor = randomColor(),
                marker = {
                    id: this.createdId,
                    longitude: event.longitude,
                    latitude: event.latitude,
                    color: randomcolor,
                    html: '<i style="color:'+ randomcolor +'" class="media-object fa fa-arrow-circle-up fa-fw fa-3x"></i>',
                    anchor: 'center center',
                    tooltip: 'Attach a view to this marker',
                };

            this.markerList.unshift(marker);

            Bus.$emit('panorama-marker-created', marker);
        }
    }
});
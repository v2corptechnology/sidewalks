Vue.component('path-viewer', {
    props: {
        viewId: {type: [Number, String], required: true}, 
        height: {type: [Number, String], required: false}
    },
    template: `<div id="path_viewer"></div>`,
    data() {
        return {
            PSV: {},
            longitude: 0,
        };
    },
    computed: {
    },
    mounted() {
        this.loadView(this.viewId);
    },
    methods: {
        loadView(viewId) {
            // Get view info
            this.$http.get('/api/views/' + viewId)
                .then(response => this.onData(response.data))
                .catch(error => {
                    console.log(error);
                    alert('Error while fetching markers');
                });
        },
        onData(data) {
            if (! Object.keys(this.PSV).length) {
                this.initPSV(data.path, data.markers);
            } else {
                this.PSV.clearMarkers();
                this.PSV.setPanorama(data.path, {latitude:0, longitude: this.longitude});
                data.markers.map(marker => this.PSV.addMarker(marker));
            }
        },
        onSelectMarker(marker) {
            if (marker.view_id) {
                this.longitude = marker.longitude;
                this.loadView(marker.view_id);
            }
        },
        onClick(event) {
            console.log({
                latitude: event.latitude,
                longitude: event.longitude,
            });
        },
        initPSV(viewPath, viewMarkers) {
            this.PSV = new PhotoSphereViewer({
                container: 'path_viewer',
                panorama: viewPath,
                loading_img: '/img/spin.svg',
                navbar: false,
                default_fov: 70,
                mousewheel: false,
                time_anim: false,
                gyroscope: true,
                markers: viewMarkers,
                size: {
                    height: this.height || 500
                },
            });

            this.PSV.on('select-marker', this.onSelectMarker);
            this.PSV.on('click', this.onClick);
        }
    }
});
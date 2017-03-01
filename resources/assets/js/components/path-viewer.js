import randomColor from 'randomcolor';

Vue.component('path-viewer', {
    props: {
        viewId: {type: [Number, String], required: true}, 
        height: {type: [Number, String], required: false},
        fullscreen: {type: [Boolean], required: false},
        caption: {type: [String], required: false},
        editable: {type: [Boolean], required: false},
    },
    template: `<div id="path_viewer"></div>`,
    data() {
        return {
            PSV: null,
            longitude: 0,
            currentMarker: null,
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
            if (! this.PSV) {
                var markers = data.markers.map(marker => marker.psv_info);
                this.initPSV(data.imageUrl, markers);
            } else {
                this.PSV.clearMarkers();
                this.PSV.setPanorama(data.imageUrl, {latitude:0, longitude: this.longitude});
                data.markers.map(marker => this.PSV.addMarker(marker.psv_info));
            }
        },
        onSelectMarker(marker) {
            if (marker.view_id) {
                this.longitude = marker.longitude;
                this.loadView(marker.view_id);
            }
        },
        onClick(event) {
            if (this.editable) {
                this.clearUnsavedMarker();
                this.addMarker(event);
            }
        },
        clearUnsavedMarker() {
            if (this.currentMarker) {
                this.PSV.removeMarker(this.currentMarker);
                Bus.$emit('marker-removed', this.currentMarker);
                this.currentMarker = null;
            }
        },
        addMarker(event) {
            var randomcolor = randomColor();
            this.currentMarker = this.PSV.addMarker({
                id: Math.random().toString(36).substr(2, 5),
                longitude: event.longitude,
                latitude: event.latitude,
                x: event.texture_x,
                y: event.texture_y,
                color: randomcolor,
                html: '<i style="color:'+ randomcolor +'" class="media-object fa fa-arrow-circle-up fa-fw fa-3x"></i>',
                anchor: 'center center',
                tooltip: 'Attach a view to this marker',
            });
            Bus.$emit('marker-created', this.currentMarker);
        },
        initPSV(viewPath, viewMarkers) {
            this.PSV = new PhotoSphereViewer({
                container: 'path_viewer',
                panorama: viewPath,
                loading_img: '/img/spin.svg',
                caption: this.caption || null,
                navbar: this.fullscreen ? ['fullscreen'] : false,
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
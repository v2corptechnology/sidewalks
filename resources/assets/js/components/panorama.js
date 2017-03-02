Vue.component('panorama', {
    props: {
        image: {type: String, required: true},
        markers: {type: Array, required: false, default: []}, 
        height: {type: [Number, String], required: false, default: 500},
        fullscreen: {type: Boolean, required: false, default: true},
        caption: {type: String, required: false, default: null},
        editable: {type: Boolean, required: false, default: false},
    },
    template: `<div id="PSV"></div>`,
    data() {
        return {
            PSV: null,
        };
    },
    created() {
        Bus.$on('panorama-marker-created', this.onMarkerCreated);
        Bus.$on('panorama-marker-removed', this.onMarkerRemoved);
    },
    mounted() {
        this.initPano();
    },
    methods: {
        initPano() {
            if (!this.image) return;

            this.PSV = new PhotoSphereViewer({
                panorama: this.image,
                container: 'PSV',
                loading_img: '/img/spin.svg',
                caption: this.caption,
                navbar: this.fullscreen ? ['fullscreen', 'caption'] : false,
                default_fov: 70,
                mousewheel: false,
                time_anim: false,
                gyroscope: true,
                markers: this.markers,
                size: {height: this.height},
            });

            this.PSV.on('select-marker', this.onSelectMarker);
            this.PSV.on('unselect-marker', this.onUnselectMarker);
            this.PSV.on('click', this.onClick);
        },
        onSelectMarker(marker) {
            Bus.$emit('panorama-marker-selected', marker);

            if (this.editable) {
                window.location.href = marker.markable.urls.edit;
                return;
            }

            window.location.href = marker.markable.urls.show;

            /*if (marker.target) {
                this.PSV.setPanorama(marker.target);
                return;
            }*/
        },
        onUnselectMarker(marker) {
            Bus.$emit('panorama-marker-unselected', marker);
        },
        onClick(event) {
            Bus.$emit('panorama-click', event);

            /*
            if (this.isEditable) {
                this.PSV.on('click', this.onPSVClick);
            }
            if (this.currentMarker) {
                this.PSV.removeMarker(this.currentMarker);
                this.currentMarker = null;
            }

            this.currentMarker = this.PSV.addMarker({
                id: '#' + Math.random(),
                longitude: event.longitude,
                latitude: event.latitude,
                x: event.texture_x,
                y: event.texture_y,
                image: '/img/pin_red.svg',
                width: 32,
                height: 32,
                anchor: 'bottom center',
                tooltip: 'This marker is not saved',
            });

            Bus.$emit('marker-created', this.currentMarker);
            */
        },
        onMarkerCreated(marker) {
            this.PSV.addMarker(marker);
        },
        onMarkerRemoved(identifier) {
            this.PSV.removeMarker(identifier);
        }
    }
});
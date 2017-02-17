Vue.component('pano', {
    props: ['panorama', 'rawMarkers', 'editable', 'height'],
    template: `<div id="photosphere"></div>`,
    data() {
        return {
            PSV: null,
            markers: [],
            currentMarker: null,
            panoramaImage: null,
            isEditable: (this.editable && this.editable == 'true') || false,
        };
    },
    computed: {
        PSVFormattedMarkers() {
            return this.markers.map(function(marker) {
                marker.image = marker.psv_info.image;
                marker.anchor = marker.psv_info.anchor;
                marker.width = marker.psv_info.width;
                marker.height = marker.psv_info.height;
                marker.tooltip = marker.psv_info.tooltip;
                delete marker.psv_info;

                return marker;
            });
        },
    },
    created() {
        Bus.$on('marker-saved', this.onMakerSaved);
        Bus.$on('item-isolated', this.onItemIsolated);
        Bus.$on('panorama-image-updated', this.onPanoramaImageUpdated);
        this.markers = JSON.parse(this.rawMarkers || "[]");
        this.panoramaImage = this.panorama || null;
    },
	mounted() {
		this.initPSV();
	},
    methods: {
        initPSV() {
            if (!this.panoramaImage) return;

            this.PSV = new PhotoSphereViewer({
                panorama: this.panoramaImage,
                container: 'photosphere',
                loading_img: '/img/spin.svg',
                navbar: false,
                default_fov: 70,
                mousewheel: false,
                /*time_anim: false,*/
                gyroscope: true,
                markers: this.PSVFormattedMarkers,
                size: {
                    height: this.height || 500
                },
            });

            this.PSV.on('select-marker', this.onPSVSelectMarker);
            this.PSV.on('unselect-marker', this.onPSVUnselectMarker);
            if (this.isEditable) {
                this.PSV.on('click', this.onPSVClick);
            }
        },
        onPSVSelectMarker(marker) {
            Bus.$emit('marker-selected', marker);
            marker.image = '/img/pin_blue.svg';
            this.PSV.updateMarker(marker);
        },
        onPSVUnselectMarker(marker) {
            Bus.$emit('marker-unselected', marker);
            marker.image = '/img/pin_green.svg';
            this.PSV.updateMarker(marker);
        },
        onPSVClick(event) {
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
        },
        onPanoramaImageUpdated(image) {
            if (this.PSV) {
                this.PSV.setPanorama(image);
            } else {
                this.panoramaImage = image;
                this.initPSV();
            }
        },
        onMakerSaved(marker) {
            marker.image = '/img/pin_green.svg',
            this.PSV.updateMarker(marker);
            this.currentMarker = null;
        },
        onItemIsolated(item) {
            if (item.id in this.PSV.hud.markers) {
                this.PSV.gotoMarker(item.id, 500);
            }
        }
    }
});
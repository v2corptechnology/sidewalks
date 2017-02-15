Vue.component('pano-viewer', {
	props: ['panorama', 'markers'],
	template: `<div id="photosphere"></div>`,
    data() {
        return {
            PSV: null,
            currentMarker: null,
        };
    },
    created() {
        Bus.$on('marker-saved', this.onMarkerCreated);
    },
	mounted() {
        this.initPSV();
	},
    methods: {
        initPSV() {
            this.PSV = new PhotoSphereViewer({
                panorama: this.panorama,
                container: 'photosphere',
                loading_img: '/img/spin.svg',
                navbar: false,
                default_fov: 70,
                mousewheel: false,
                /*time_anim: false,*/
                gyroscope: true,
                markers: JSON.parse(atob(this.markers)),
                size: {
                    height: this.height || 500
                },
            });

            this.PSV.on('click', this.onPSVClick);
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
                image: '/img/pin_red.svg',
                width: 32,
                height: 32,
                anchor: 'bottom center',
                tooltip: '[Click to see item]',
                data: {
                    isSaved: false,
                }
            });

            Bus.$emit('marker-created', this.currentMarker);
        },
        onMarkerCreated(marker) {
            marker.image = '/img/pin_green.svg',
            this.PSV.updateMarker(marker);
        }
    },
});
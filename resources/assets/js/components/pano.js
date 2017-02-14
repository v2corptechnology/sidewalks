Vue.component('pano', {
    props: ['panorama', 'markers'],
    template: `<div id="photosphere"></div>`,
    data() {
        return {PSV: null};
    },
	mounted() {
		this.initPSV();
        Bus.$on('item-isolated', this.onItemIsolated);
	},
    methods: {
        initPSV() {
            var self = this;
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

            this.PSV.on('select-marker', function(marker) {
                Bus.$emit('marker-selected', marker);
                marker.image = '/img/pin_blue.svg';
                self.PSV.updateMarker(marker);
            });

            this.PSV.on('unselect-marker', function(marker) {
                Bus.$emit('marker-unselected', marker);
                marker.image = '/img/pin_green.svg';
                self.PSV.updateMarker(marker);
            });
        },
        onItemIsolated(item) {
            if (item.id in this.PSV.hud.markers) {
                this.PSV.gotoMarker(item.id, 500);
            }
        }
    }
});
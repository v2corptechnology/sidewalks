Vue.component('pano', {
    props: ['panorama', 'markers'],
    template: `<div id="photosphere"></div>`,
    data() {
        return {};
    },
	mounted() {
		this.initPSV();
	},
    methods: {
        initPSV() {
            var PSV = new PhotoSphereViewer({
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

            PSV.on('select-marker', function(marker) {
                //this.$emit('select-marker');
                var notMatchingItems = document.querySelectorAll('.item:not([data-item-id="'+ marker.item_id +'"])');
                for (var i = 0; i < notMatchingItems.length; i++) {
                    notMatchingItems[i].classList.toggle('hidden');
                }
            });

            PSV.on('unselect-marker', function(marker) {
                var hiddenItems = document.querySelectorAll('.item.hidden');
                for (var i = 0; i < hiddenItems.length; i++) {
                    hiddenItems[i].classList.toggle('hidden');
                }
            });
        }
    }
});
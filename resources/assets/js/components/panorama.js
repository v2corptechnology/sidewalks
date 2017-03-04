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
            visitedDiaporamas: [{
                id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1), 
                imageUrl: this.image
            }],
        };
    },
    created() {
        Bus.$on('panorama-marker-created', this.onMarkerCreated);
        Bus.$on('panorama-marker-removed', this.onMarkerRemoved);
    },
    mounted() {
        this.initPano();

        // Quick and dirty code
        var self = this;
        Mousetrap.bind('return', function() {
            if (self.visitedDiaporamas.length > 1) {
                // Remove current visit
                self.visitedDiaporamas.pop();
                // Load previous visit
                var previous = self.visitedDiaporamas[self.visitedDiaporamas.length-1];
                self.PSV.clearMarkers();
                self.PSV.setPanorama(previous.imageUrl)
                    .then(() => self.loadMarkers(previous.id));
            }
        });
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
            this.PSV.on('ready', this.onReady);
            this.PSV.on('over-marker', this.onOverMarker);
            this.PSV.on('leave-marker', this.onLeaveMarker);
        },
        onSelectMarker(marker) {
            Bus.$emit('panorama-marker-selected', marker);

            if (this.editable) {
                window.location.href = marker.markable.urls.edit;
                return;
            }

            // Quick and dirty code
            if (! this.editable) {
                this.visitedDiaporamas.push({
                    id: marker.markable.id, 
                    imageUrl: marker.markable.imageUrl
                });
            }

            this.PSV.clearMarkers();
            this.PSV.setPanorama(marker.markable.imageUrl)
                .then(() => this.loadMarkers(marker.markable.id));
        },
        onUnselectMarker(marker) {
            Bus.$emit('panorama-marker-unselected', marker);
        },
        onReady(event) {
            Bus.$emit('panorama-ready', event);
        },
        onClick(event) {
            Bus.$emit('panorama-click', event);

            if (! this.editable) {
                var cards = document.querySelectorAll('#cards .col-sm-3'),
                    displayedCard = cards[Math.floor(Math.random()*cards.length)];   

                if (cards.length) this.PSV.showPanel(displayedCard.innerHTML);
            }
        },
        onMarkerCreated(marker) {
            this.PSV.addMarker(marker);
        },
        onMarkerRemoved(identifier) {
            this.PSV.removeMarker(identifier);
        },
        onOverMarker(marker) {
            Bus.$emit('panorama-hover', marker.id);
        },
        onLeaveMarker(marker) {
            Bus.$emit('panorama-leave', marker.id);
        },
        loadMarkers(panoramaId) {
            this.$http.get('/api/views/' + panoramaId)
                .then(response => {
                    this.PSV.setCaption(response.data.caption);
                    response.data.markers.map(marker => this.PSV.addMarker(marker));
                })
                .catch(error => {
                    console.log(error);
                    alert('Error while fetching markers');
                });
        }
    }
});
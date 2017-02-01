Vue.component('pano-viewer', {
	props: ['panorama', 'markers', 'items', 'target-url'],
	/*
	 {
        product: {
            type: Object,
            required: true
        }
    },
    */
	template: `<div>
					<div id="photosphere"></div>
					<div id="js-add-marker" class="hidden">
						<fieldset>
							<div class="form-group">
					            <label for="item" class="control-label">Select the item</label>
					            <select class="form-control js-select-item" name="item" id="item">
					                <option value="">Choose</option>
					                <option :value="item.id" v-for="item in itemList">{{ item.title }}</option>
					            </select>
					        </div>
					        <button class="btn btn-default js-cancel-creation" type="submit">Cancel</button>
					        <button class="btn btn-primary" id="js-save-btn" type="submit">Save</button>
				        </fieldset>
			        </div>
				</div>`,
	data() {
		return {
		};
	},
	computed: {
		itemList() {
			return JSON.parse(this.items);
		}
	},
	methods: {
	},
	mounted() {
		var vm = this;

		console.log();

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
        PSV.on('click', updateMarker);

        PSV.on('open-panel', function (event) {
            $('.js-cancel-creation').on('click', function(event){
                event.preventDefault();
                PSV.hidePanel();
            });

	        $('select').change(function(event){
	        	currentMarker.item_id = $(this).val();
	        });

            $('#js-save-btn').on('click', function(event){
            	$(this).parents('fieldset').attr('disabled', 'disabled');

	            vm.$http.post(vm.targetUrl, {
	            	item_id: currentMarker.item_id, 
	            	latitude: currentMarker.latitude, 
	            	longitude: currentMarker.longitude,
	            	latitude_px: 1000,
	            	longitude_px: 1000,
	            	tooltip: 'Tooltip',
	            })
	                .then(response => {
	                	currentMarker.image = '/img/pin_green.svg',
	                	PSV.updateMarker(currentMarker);
	                	currentMarker = null;
            			$(this).parents('fieldset').attr('disabled', 'false');
            			PSV.hidePanel();
	                }, (response) => {
	                    alert('error');
            			$(this).parents('fieldset').attr('disabled', 'false');
	                });
            });
        });
        
        PSV.on('close-panel', function (event) {
            if (! currentMarker.data.isSaved) {
                PSV.removeMarker(currentMarker);
            }
        });

        var hasMarker = false;
        var currentMarker = null;

        function updateMarker(event) {

            hasMarker = !hasMarker;

            currentMarker = PSV.addMarker({
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

            /*document.getElementById('js-point').value = JSON.stringify({
                'px': [event.texture_x, event.texture_y],
                'deg': [event.latitude, event.longitude],
            });*/
        
            PSV.showPanel(document.getElementById('js-add-marker').innerHTML);
        };
        /*PSV.on('select-marker', function(marker) {
          if (marker.data && marker.data.generated) {
            PSV.removeMarker(marker);
          }
        });*/
	}
});
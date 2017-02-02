Vue.component('item', {
    props: ['user'],

    data() {
        return {
            scrapedUrl: null,
            selectedTab: 'import',
            item: {
                quantity: 1,
                images: []
            },
        };
    },

    mounted() {
        $(function(){
            $('.js-categories').select2({
                placeholder: 'Choose'
            });
        });
    },

    methods: {
        onItemScraped(item) {
            this.item = item;
            this.scrapedUrl = item.scrapedUrl;
            this.selectedTab = "manual";
        },
        onItemSelected(item) {
            this.item = item;
            this.selectedTab = "manual";
        },
        onFileChange(event) {
            var files = event.target.files || event.dataTransfer.files;

            for (var i = files.length - 1; i >= 0; i--) {
                this.createImage(files[0]);
            }

            event.target.value = null;
        },
        createImage(file) {
            var image = new Image(),
                reader = new FileReader(),
                vm = this;

            reader.onload = (event) => {
                vm.item.images.push(event.target.result);
            };

            reader.readAsDataURL(file);
        }
    }
});

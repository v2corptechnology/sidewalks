Vue.component('panorama-chooser', {
    props: ['rawPanorama'],
    data() {
        return {
            panorama: this.rawPanorama
        };
    },
    methods: {
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var self = this,
                reader = new FileReader();

            reader.onload = (e) => {
                self.panorama = e.target.result;
                Bus.$emit('panorama-image-updated', self.panorama);
            };
            reader.readAsDataURL(file);
        },
    }
});

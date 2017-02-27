Vue.component('view-uploader', {
    template: `
        <div>
            <div v-if="view">
                <a :href="view.urls.edit">
                    <img :src="imageData" class="img-responsive" alt="New view" />
                </a>
            </div>
            <input v-else type="file" name="file" id="file" accept="image/*" @change="onImageChange">
        </div>
    `,
    data() {
        return {
            view: null,
            imageData: null,
        };
    },
    methods: {
        onImageChange(event) {
            var files = event.target.files || event.dataTransfer.files;

            if (!files.length) return;

            this.createPreview(files[0]);
            this.uploadImage(files[0]);

        },
        uploadImage(file) {
            var formData = new FormData();
            formData.append('image', file);

            this.$http.post('/api/views', formData)
                .then(response => this.view = response.body)
                .catch(error => {console.log(error); alert('Error while uploading image')});
        },
        createPreview(file) {
            var self = this,
                reader = new FileReader();

            reader.onload = (event) => self.imageData = event.target.result;
            reader.readAsDataURL(file);
        },
    }
});
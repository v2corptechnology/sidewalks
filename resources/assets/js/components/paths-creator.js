Vue.component('paths-creator', {
    template: `
        <fieldset :disabled="isSaving">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Name a new path" v-model="name"/>
            </div>

            <div class="form-group">
                <div v-if="image">
                    <a href="#" title="Remove image" @click="removeImage">
                        <img :src="image" class="img-responsive" :alt="name" />
                    </a>
                </div>
                <span v-else class="form-control">
                    <input type="file" name="file" id="file" accept="image/*" @change="onImageChange">
                </span>
            </div>

            <button class="btn btn-primary btn-block" :disabled="isInvalid" @click.prevent="savePath">Create path</button>

        </fieldset>
    `,
    props: ['user'],
    data() {
        return {
            isSaving: false,
            name: null,
            image: null,
            imageFile: null,
        };
    },
    computed: {
        isInvalid() {
            return !this.image || !this.name;
        }
    },
    methods: {
        onImageChange(event) {
            var files = event.target.files || event.dataTransfer.files;

            if (!files.length) return;

            this.imageFile = files[0];
            this.createPreview();
        },
        removeImage() {
            this.image = null;
            this.imageFile = null;
        },
        createPreview() {
            var self = this,
                reader = new FileReader();

            reader.onload = (event) => self.image = event.target.result;
            reader.readAsDataURL(this.imageFile);
        },
        savePath() {
            this.isSaving = true;

            var formData = new FormData();
            formData.append('panorama', this.imageFile);
            formData.append('name', this.name);
            formData.append('user_id', this.user.id);

            this.$http.post('/api/paths/', formData)
                .then(response => {
                    Bus.$emit('path-created', response.body.data);
                    this.name = '';
                    this.removeImage();
                    this.isSaving = false;
                })
                .catch(error => {
                    console.log(error);
                    this.isSaving = false;
                    alert('Error while isSaving your path');
                });
        }
    }
});
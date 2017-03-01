Vue.component('paths', {
    template: `
        <ul class="row list-unstyled">
            <li class="col-sm-4" v-for="path in pathsList">
                <a :href="path.urls.edit" :title="path.name">
                        <img v-if="path.mainPanoramaUrl" class="img-responsive" :src="path.mainPanoramaUrl" :alt="path.name">
                        <p v-else>No panorama image</p>
                        {{ path.name }}
                        <small class="pull-right">{{ path.panoramas.length }} views</small>
                </a>
            </li>
        </ul>
    `,
    props: ['paths'],
    data() {
        return {
            pathsList: [],
        };
    },
    created() {
        Bus.$on('path-created', this.onPathCreated);
        this.pathsList = this.paths;
    },
    methods: {
        onPathCreated(path) {
            this.pathsList.push(path);
        }
    }
});
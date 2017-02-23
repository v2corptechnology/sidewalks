Vue.component('paths', {
    template: `
        <div>
            <ul>
                <li v-for="path in paths"><a :href="path.url">{{ path.name }}</a> <small>({{ path.views.length }} views)</small></li>
                <li>
                    <input type="text" placeholder="Name a new path" v-model="name" @keyup="onKeyUp" />
                </li>
            </ul>
        </div>
    `,
    data() {
        return {
            paths: [],
            name: '',
        };
    },
    created() {
        this.$http.get('/api/paths/')
            .then(response => this.paths = response.data);
    },
    methods: {
        onKeyUp(event) {
            if (event.keyCode == 13) {
                this.$http.post('/api/paths/', {name: this.name})
                    .then(response => {
                        this.paths.push(response.body.data)
                        this.name = '';
                    })
                    .catch(error => console.log(error));

                event.preventDefault();
            }
        }
    }
});
Vue.component('paths', {
    template: `
        <div>
            <ul>
                <li v-for="path in paths">
                    {{ path.name }} <small>({{ path.views.length }} views)</small>
                     — <a :href="path.urls.edit">Edit</a> — <a :href="path.urls.view">View</a>
                </li>
                <li>
                    <input type="text" placeholder="Name a new path" v-model="name" @keyup="onKeyUp" />
                </li>
            </ul>
        </div>
    `,
    props: ['user'],
    data() {
        return {
            paths: [],
            name: '',
        };
    },
    created() {
        this.$http.get('/api/users/'+ this.user.id +'/paths/')
            .then(response => this.paths = response.data)
            .catch(error => alert('Error fetching your paths'));
    },
    methods: {
        onKeyUp(event) {
            if (event.keyCode == 13) {
                this.$http.post('/api/users/'+ this.user.id +'/paths/', {name: this.name})
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
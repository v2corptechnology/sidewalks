Vue.component('paths', {
    template: `
        <div>
            <ul>
                <li v-for="path in paths">
                    <a :href="path.urls.view">{{ path.name }}</a> <small>({{ path.panoramas.length }} panoramas)</small>
                     — <a :href="path.urls.edit">Edit</a>
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
                this.$http.post('/api/paths/', {
                        name: this.name,
                        user_id: this.user.id,
                    })
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
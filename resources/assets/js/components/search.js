export default {
    template: `<div class="form-group">
        <input v-model="q" type="text" :class="inputClasses" placeholder="Поиск" @keyup="search">
        <ul v-if="results.length" class="search-results">
            <li v-for="result in results">
                <a href="/{{ result.slug }}">{{ result.name }}</a>
            </li>
        </ul>
    </div>`,
    data() {
        return {
            q: null,
            results: []
        }
    },
    methods: {
        search() {
            this.$http.get(`/users?q=${this.q}&limit=5`).then(res => {
                this.results = res.body;
            })
        }
    },
    computed: {
        inputClasses() {
            let classes = `form-control search-input`;
            if(this.results.length) {
                classes += ` has-results`
            }

            return classes;
        }
    }
}
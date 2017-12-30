<template>
    <div class="form-group">
        <input v-model="query" type="text" :class="inputClasses" placeholder="Поиск" @keyup="search">
        <ul v-if="results.length" class="search-results">
            <li v-for="result in results" @click="go(result.slug)" class="element">
                {{ result.name }}
            </li>
            <li class="row">
                <a href="https://www.algolia.com" target="_blank"><img class="col-xs-5 col-xs-offset-7" src="https://www.algolia.com/static_assets/images/press/downloads/algolia-logo-light.svg" alt=""></a>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                query: null,
                results: []
            }
        },
        methods: {
            go(slug) {
                window.location.href = `/${slug}/wishes`
            },
            search() {
                axios.get(`/api/users?query=${this.query}`).then(res => {
                    this.results = res.data;
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
</script>
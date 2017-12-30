<template>
    <div class="form-group search">
        <input v-model="query" type="text" :class="inputClasses" placeholder="Поиск"
               @keyup.27.prevent="reset"
               @keydown.40.prevent="focusResults">

        <ul v-if="results.length" class="search-results">
            <li v-for="(result, index) in results" class="element" :tabindex="index+1"
                @click="go(result.slug)"
                @keyup.27.prevent="reset"
                @keydown.13.prevent="go(result.slug)"
                @keydown.39.prevent="go(result.slug)"
                @keydown.38.prevent="focusPrev"
                @keydown.40.prevent="focusNext"
                @keydown.8.prevent="deleteKey"
            >
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
        watch: {
            query() {
                this.search()
            }
        },
        methods: {
            deleteKey() {
                this.query = this.query.slice(0, -1);
                this.focusInput();
            },
            focusInput() {
                $('.search input').focus();
            },
            focusResults() {
                $('.search .search-results .element:first-child').focus();
            },
            focusNext() {
                $('.search .search-results .element:focus').next().focus();
            },
            focusPrev() {
                $('.search .search-results .element:focus').prev().focus();
            },
            reset() {
                this.results = [];
                this.query = '';
                this.focusInput();
            },
            go(slug) {
                window.location.href = `/${slug}/wishes`
            },
            search() {
                if(!this.query) return;

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
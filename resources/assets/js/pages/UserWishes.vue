<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" v-if="user">
                <h1>{{ user.name }}</h1>
                <div class="row">
                    <div v-if="isMe" class="col-sm-4 col-md-3">
                        <new-wish></new-wish>
                    </div>
                    <router-link :to="`/wishes/${wish.id}`" v-for="wish in wishes" :key="wish.id">
                        <div class="col-sm-4 col-md-3">
                            <wish :wish="wish"></wish>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import {sortBy, reverse} from 'lodash';

    import Wish from '../components/Wish.vue';
    import NewWish from '../components/NewWish.vue';

    export default {
        components: {Wish, NewWish},
        created() {
            if(!this.user) {
                this.fetchUser(this.userSlug);
            }
            this.fetchUserWishes(this.userSlug);
        },
        computed: {
            ...mapGetters(['activeWishesByUserId', 'userBySlug']),
            userSlug() {
                return this.$route.params.slug
            },
            user() {
                return this.userBySlug(this.userSlug)
            },
            isMe() {
                return window.Laravel.user_id === this.user.id;
            },
            wishes() {
                if(!this.user) return [];

                let wishes = this.activeWishesByUserId(this.user.id);
                return reverse(sortBy(wishes, 'id'))
            }
        },
        methods: {
            ...mapActions(['fetchUserWishes', 'fetchUser'])
        }
    }
</script>
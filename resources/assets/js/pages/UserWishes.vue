<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" v-if="user">
                <div class="row">
                    <div v-if="isMe" class="col-sm-4 col-md-3">
                        <new-wish></new-wish>
                    </div>
                    <a :href="`/wishes/${wish.id}`" v-for="wish in wishes">
                        <div class="col-sm-4 col-md-3">
                            <wish :wish="wish"></wish>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

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
            ...mapGetters(['wishesByUserId', 'userBySlug']),
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
                return this.user && this.wishesByUserId(this.user.id)
            }
        },
        methods: {
            ...mapActions(['fetchUserWishes', 'fetchUser'])
        }
    }
</script>
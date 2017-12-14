<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" v-if="user">
                <h1>{{ user.name }}</h1>
                <div class="row">
                    <div class="col-md-3 col-xs-8 col-xs-offset-2 col-md-offset-0">
                        <div class="square-image material" :style="`background-image: url('${user.avatar_url}')`"></div>
                        <template v-if="isMe">
                            <br>
                            <router-link class="btn btn-default btn-block" :to="`/${user.slug}/edit`"><i class="fa fa-pencil"></i> Изменить</router-link>
                        </template>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <p>Дата регистрации {{ user.created_at | date }}</p>
                        <router-link class="btn btn-primary" :to="`/${user.slug}/wishes`">Смотреть Желания</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        created() {
            this.fetchUser(this.userSlug);
            this.fetchUserWishes(this.userSlug)
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
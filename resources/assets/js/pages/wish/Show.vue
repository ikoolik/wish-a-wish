<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" v-if="wish">
                <h1>{{ wish.name }}</h1>
                <div class="row">
                    <div class="col-sm-3 col-xs-8 col-xs-offset-2 col-sm-offset-0">
                        <div class="square-image material" :style="`background-image: url('${wish.image}')`"></div>
                        <div class="controll-buttons hidden-xs">
                            <span class="btn btn-block" disabled v-if="isBooked">Желание забронировано</span>
                            <span class="btn btn-block" disabled v-if="isArchived">Подарено {{ wish.archived_at | date }}</span>

                            <span class="btn btn-primary btn-block" v-if="canBook" @click="book"><i class="fa fa-lock"></i> Забронировать</span>
                            <span class="btn btn-primary btn-block" v-if="canUnbook" @click="unbook"><i class="fa fa-unlock-alt"></i> Отменить бронь</span>

                            <span class="btn btn-primary btn-block" v-if="canArchive" @click="archive"><i class="fa fa-gift"></i> Подарено</span>
                            <router-link class="btn btn-block btn-default" v-if="canChange" :to="`/wishes/${wish.id}/edit`"><i class="fa fa-pencil"></i> Изменить</router-link>
                            <span class="btn btn-danger btn-block" v-if="canDelete" @click="destroy"><i class="fa fa-trash"></i> Удалить</span>
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div>
                            <i v-if="!wish.description">Комментарий отсутствует</i>
                            <div v-html="description"></div>
                        </div>
                        <hr>
                    </div>
                    <div class="controll-buttons visible-xs col-xs-12">
                        <span class="btn btn-block" disabled v-if="isBooked">Желание забронировано</span>
                        <span class="btn btn-block" disabled v-if="isArchived">Подарено {{ wish.archived_at | date }}</span>

                        <span class="btn btn-primary btn-block" v-if="canBook" @click="book"><i class="fa fa-lock"></i> Забронировать</span>
                        <span class="btn btn-primary btn-block" v-if="canUnbook" @click="unbook"><i class="fa fa-unlock-alt"></i> Отменить бронь</span>

                        <span class="btn btn-primary btn-block" v-if="canArchive" @click="archive"><i class="fa fa-gift"></i> Подарено</span>
                        <router-link class="btn btn-block btn-default" v-if="canChange" :to="`/wishes/${wish.id}/edit`"><i class="fa fa-pencil"></i> Изменить</router-link>
                        <span class="btn btn-danger btn-block" v-if="isMine" @click="destroy"><i class="fa fa-trash"></i> Удалить</span>
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
            this.fetchWish(this.wishId)
        },
        methods: {
            ...mapActions(['fetchWish', 'bookWish', 'unbookWish', 'archiveWish', 'deleteWish']),
            book() {
                this.bookWish(this.wish.id);
            },
            unbook() {
                this.unbookWish(this.wish.id);
            },
            archive() {
                this.archiveWish(this.wish.id);
            },
            destroy() {
                let url = `/${this.user.slug}/wishes`;
                this.deleteWish(this.wish.id).then(() => {
                    this.$router.push(url)
                })
            }
        },
        computed: {
            ...mapGetters(['wishById', 'userById']),
            description() {
                return this.wish.description
                    .replace(/\n/g, "<br>")
                    .replace(/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/g, link => {
                        return `<a href='${link}' target='_blank' rel='noopener noreferrer' title='${link}'>${link}</a>`
                    });
            },
            user() {
                return this.userById(this.wish.user_id)
            },
            wishId() {
                return +this.$route.params.wishId
            },
            wish() {
                return this.wishById(this.wishId)
            },
            isBooked() {
                return !! this.wish.booked_by;
            },
            isArchived() {
                return !! this.wish.archived_at;
            },
            isMine() {
                return this.wish.user_id === window.Laravel.user_id;
            },
            canUnbook() {
                return window.Laravel.user_id && !this.isMine && (this.wish.booked_by === window.Laravel.user_id) && !this.isArchived;
            },
            canBook() {
                return window.Laravel.user_id && !this.isMine && !this.isBooked && !this.isArchived
            },
            canArchive() {
                return this.isMine && !this.isArchived
            },
            canChange() {
                return this.isMine && !this.isArchived
            },
            canDelete() {
                return this.isMine && !this.isArchived
            }
        }
    }
</script>
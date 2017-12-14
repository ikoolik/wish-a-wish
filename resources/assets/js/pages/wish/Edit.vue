<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Изменить желание</h1>
                <div class="row">
                    <div class="col-md-3">
                        <label>Картинка</label>
                        <div class="square-image material" v-if="form.image_url" :style="`background-image: url('${form.image_url}')`"></div>
                        <div class="square-image material" v-show="!form.image_url" style="background-image: url('/images/default.png')"></div>
                        <br>
                        <uploadcare-button v-model="form.image_url" crop="256x256"></uploadcare-button>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" class="form-control" placeholder="Феррари" v-model="form.name">
                        </div>
                        <div class="form-group">
                            <label>Комментарий</label>
                            <textarea class="form-control" name="description" placeholder="Обязательно красного цвета" rows="10"  v-model="form.description"></textarea>
                        </div>
                        <hr>
                        <span class="btn btn-primary" @click="save"><i class="fa fa-save"></i> Сохранить</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UploadcareButton from '../../components/UploadcareButton.vue';
    import {pick} from 'lodash';
    import swal from 'sweetalert';

    import {mapActions, mapGetters} from 'vuex';
    export default {
        components: {UploadcareButton},
        data() {
            return {
                form: {
                    id: null,
                    image_url: null,
                    name: '',
                    description: ''
                }
            }
        },
        created() { this.fetchWish(this.wishId) },
        watch: {
            wish(wish) { this.$set(this, 'form', pick(wish, ['id', 'image_url', 'name', 'description'])); }
        },
        methods: {
            ...mapActions(['fetchWish', 'updateWish']),
            save() {
                this.updateWish(this.form).then(() => {
                    swal('Успех!', 'Желание успешно обновлено', 'success');
                }).catch(() => {
                    swal('Упс!', 'Произошла ошибка', 'error');
                })
            }
        },
        computed: {
            ...mapGetters(['wishById', 'userById']),
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
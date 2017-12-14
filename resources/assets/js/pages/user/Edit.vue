<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" v-if="user">
                <h1>Настройки пользователя</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="square-image material" :style="`background-image: url('${avatar}')`"></div>
                        <br>
                        <uploadcare-button v-model="form.avatar" crop="256x256"></uploadcare-button>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Имя</label>
                            <input type="text" class="form-control" v-model="form.name">
                        </div>
                        <div class="form-group">
                            <label>Url</label>
                            <input type="text" class="form-control" v-model="form.slug">
                        </div>
                        <hr>
                        <span v-if="!isLoading" class="btn btn-primary" @click="save"><i class="fa fa-save"></i> Сохранить</span>
                        <span v-if="isLoading" class="btn btn-primary"><i class="fa fa-spin fa-spinner"></i> Сохраняем</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UploadcareButton from '../../components/UploadcareButton.vue';
    import {mapGetters, mapActions} from 'vuex';
    import {pick} from 'lodash';

    export default {
        components: {UploadcareButton},
        data() {
            return {
                isLoading: false,
                form: {
                    name: null, slug: null, avatar: null
                }
            }
        },
        created() {
            this.fetchUser(this.userSlug);
        },
        watch: {
            user(user) {
                this.$set(this, 'form', pick(user, ['id', 'avatar', 'name', 'slug']));
            }
        },
        computed: {
            ...mapGetters(['userBySlug']),
            avatar() {
                return this.form.avatar || this.user.avatar_url;
            },
            userSlug() {
                return this.$route.params.slug
            },
            user() {
                return this.userBySlug(this.userSlug)
            }
        },
        methods: {
            ...mapActions(['fetchUser', 'updateUser']),
            save() {
                this.isLoading = true;

                let data = Object.assign({}, this.form, {current_slug : this.userSlug});
                this.updateUser(data).then(user => {
                    this.isLoading = false;
                    this.$router.push(`/${user.slug}/edit`);
                    swal('Успех!', 'Данные успешно сохранены', 'success');
                }).catch(r => {
                    this.isLoading = false;
                    console.log(r);
                    swal('Упс!', 'Произошла ошибка', 'error');
                })
            }
        }
    }
</script>
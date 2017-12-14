<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Новое желание</h1>
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

    import {mapActions} from 'vuex';
    export default {
        components: {UploadcareButton},
        data() {
            return {
                form: {
                    image_url: null,
                    name: '',
                    description: ''
                }
            }
        },
        methods: {
            ...mapActions(['createWish']),
            save() {
                this.createWish(this.form).then(wish => {
                    this.$router.push(`/wishes/${wish.id}`);
                })
            }
        }
    }
</script>
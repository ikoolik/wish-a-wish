<template>
    <span @click="openDialog" class="btn btn-default btn-block">
        <span v-if="inProgress">Загрузка...</span>
        <span v-else>Заменить Картинку</span>
    </span>
</template>

<script>
    import uploadcare from 'uploadcare-widget';
    import {each as _each} from 'lodash';

    export default {
        props: ['value', 'crop'],
        data() {
            return {
                inProgress: false
            }
        },
        methods: {
            openDialog(){
                if(this.inProgress) return false;
                let dialog = uploadcare.openDialog(null, {
                    imagesOnly: true,
                    crop: this.crop
                });
                dialog.done(file => {
                    this.inProgress = true;
                    file.done(info => {
                        this.inProgress = false;
                        this.$emit('input', info.cdnUrl);
                        this.$emit('done', info.cdnUrl);
                    });
                });
            }
        }
    }
</script>
import Vue from 'vue';

const FILE_UPLOAD_TYPE_URL = 'url';
const FILE_UPLOAD_TYPE_FILE = 'file';
export default Vue.extend({
    props: ['value'],

    data() {
        return {
            unique: Math.ceil(Math.random() * 100),
            image: null,

            url: null,
            type: null
        }
    },

    template: require('./file-picker.html'),

    created() {
        this.image = this.value
    },

    watch: {
        image(val) {
            if(val !== this.value) {
                this.$emit('input', val)
            }
        }
    },
    methods: {
        fileSelected(e) {
            let that = this;
            let input = e.target;
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    that.image = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }

            this.hideModal();
            this.type = FILE_UPLOAD_TYPE_FILE;
        },

        urlSelected() {
            this.image = this.url;

            this.hideModal();
            this.type = FILE_UPLOAD_TYPE_URL;
        },

        hideModal() {
            $(`#change-image-${this.unique}`).modal('hide');
        }
    }
})
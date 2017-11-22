<template>
    <div class="panel panel-default material disabled">
        <div class="panel-heading">
            <h3 class="panel-title">{{ wish.name }}</h3>
        </div>
        <span class="label label-danger label-booked" v-if="isBooked">Забронировано</span>
        <div class="square-image" :class="{'is-booked': isBooked}" :style="`background-image: url('${wish.image}')`"></div>
    </div>
</template>

<script>
    export default {
        props: ['wish'],
        computed: {
            isBooked() {
                return !! this.wish.booked_by;
            }
        }
    }
</script>
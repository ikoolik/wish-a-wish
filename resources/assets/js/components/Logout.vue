<template>
    <a href="#" @click.prevent="logout"><i class="fa fa-btn fa-sign-out"></i>Выйти</a>
</template>

<script>
    import axios from 'axios';

    export default {
        methods: {
            logout() {
                axios.post(`/logout`).then(() => location.href = '/login');
            }
        }
    }
</script>
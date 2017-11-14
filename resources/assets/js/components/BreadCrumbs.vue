<template>
    <ul class="nav navbar-nav navbar-left">
        <template v-for="(el, i) in elements">
            <li v-if="isLast(i)" class="active">{{ el.title }}</li>
            <li v-if="!isLast(i)"><router-link :to="el.href" v-if="!isLast(i)">{{ el.title }}</router-link></li>
            <li v-if="!isLast(i)" class="separator hidden-xs">|</li>
        </template>
    </ul>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        methods: {
            isLast(i) {
                return i === this.elements.length - 1;
            }
        },
        computed: {
            ...mapGetters(['userBySlug']),
            elements() {
                switch(this.$route.name) {
                    case 'user.wishes':
                        return this.user ? [this.userBC, this.wishesBC] : [];
                        break;
                    case 'user':
                        return this.user ? [this.userBC] : [];
                    default:
                        return []
                }
            },
            user() {
                let slug = this.$route.params.slug;
                return this.userBySlug(slug)
            },
            userBC()
            {
                if(!this.user) return null;
                return { title: this.user.name, href: `/${this.user.slug}`}
            },
            wishesBC()
            {
                if(!this.user) return null;
                return {title: 'Желания', href: `/${this.user.slug}/wishes`};
            }
        }
    }
</script>
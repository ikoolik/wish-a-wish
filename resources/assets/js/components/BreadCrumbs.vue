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
            ...mapGetters(['userBySlug', 'userById', 'wishById']),
            elements() {
                switch(this.$route.name) {
                    case 'user.wishes':
                        return this.user ? [this.userBC, this.wishesBC] : [];
                    case 'user.show':
                        return this.user ? [this.userBC] : [];
                    case 'user.edit':
                        return this.user ? [this.userBC, this.editUserBC] : [];
                    case 'wishes.show':
                        return this.wish && this.user ? [this.userBC, this.wishesBC, this.wishBC] : [];
                    case 'wishes.edit':
                        return this.wish && this.user ? [this.userBC, this.wishesBC, this.wishBC, this.editWishBC] : [];
                    default:
                        return []
                }
            },
            wish() {
                let id = +this.$route.params.wishId;
                return this.wishById(id);
            },
            user() {
                let slug = this.$route.params.slug;
                let user = this.userBySlug(slug);
                if(!user && this.wish) {
                    user = this.userById(this.wish.user_id)
                }

                return user;
            },
            userBC()
            {
                if(!this.user) return null;
                return { title: this.user.name, href: `/${this.user.slug}`}
            },
            editUserBC()
            {
                if(!this.user) return null;
                return { title: 'Изменить', href: `/${this.user.slug}/edit`}
            },
            wishesBC()
            {
                if(!this.user) return null;
                return {title: 'Желания', href: `/${this.user.slug}/wishes`};
            },
            wishBC()
            {
                if(!this.wish) return null;
                return {title: this.wish.name, href: `/wishes/${this.wish.id}`};
            },
            editWishBC()
            {
                if(!this.wish) return null;
                return {title: 'Изменить', href: `/wishes/${this.wish.id}/edit`};
            }
        }
    }
</script>
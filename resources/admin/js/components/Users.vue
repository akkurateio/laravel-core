<template>
    <div class="contacts">
        <template v-if="items.length === 0 && !loading">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <div class="my-2 text-muted text-sm text-center">
                    Aucun utilisateur associé !
                </div>
            </div>
        </template>
        <template v-else-if="loading">
            <div
                class="loader d-flex justify-content-center align-items-center"
            >
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </template>
        <template v-else>
            <div
                :key="item.uuid"
                v-for="item of array"
                class="d-flex align-items-center justify-content-between p-2"
            >
                <div class="icon gray mr-2">
                    <Icon name="User-identification" />
                </div>
                <div style="flex: 1">
                    <a
                        :href="
                            '/brain/' +
                            account.uuid +
                            '/admin/users/' +
                            item.id +
                            '/edit'
                        "
                        class="text-xs font-medium"
                    >
                        {{ item.lastname }} {{ item.firstname }}
                    </a>
                    <div class="text-2xs text-muted">
                        {{ item.roles }}
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import Default from './modal/Default';

export default {
    props: ['parentProps'],
    data() {
        return {
            properties: null,
        };
    },
    mounted() {
        this.init();
    },
    methods: {
        async removeItem(item) {
            const confirm = await this.$modal.show(Default, {
                title: 'Confirmation',
                body: `<p>Etes-vous certain.e de vouloir supprimer cette relation ?</p><p class="text-xs text-muted">'utilisateur ne sera pas supprimé !</p>`,
            });
            if (!confirm) {
                return;
            }
            const payload = {
                item,
                event: this.properties.plural,
                id: this.properties.id,
            };
            await this.$store.dispatch('users/removeItem', payload);
        },
        async init() {
            this.properties = JSON.parse(this.parentProps);
            const payload = {
                event: this.properties.plural,
                id: this.properties.id,
            };
            await this.$store.dispatch('users/fetchAll', payload);
        },
        add() {
            this.adding = true;
        },
    },
    computed: {
        array() {
            return [...this.items.sort((a, b) => b.created_at - a.created_at)];
        },
        account() {
            return this.$store.state.account.entity;
        },
        items() {
            return this.$store.state.users.items;
        },
        loading() {
            return this.$store.state.users.loading;
        },
    },
};
</script>
<style lang="scss">
.flip-list-move {
    transition: all 0.35s;
}
.flip-list-enter-active,
.list-leave-active {
    transition: all 0.3s ease-in-out;
}
.flip-list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>

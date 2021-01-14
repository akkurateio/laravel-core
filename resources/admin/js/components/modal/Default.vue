<template>
    <div ref="modal" class="akk-modal akk-modal-default">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h5>{{ title }}</h5>
            <a href="#" class="close" @click.stop="close(false)">
                <Icon name="Close" />
            </a>
        </div>
        <div style="flex: 1">
            <div v-if="body.trim() !== ''" v-html="body"></div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button
                @click="close(false)"
                type="button"
                class="btn btn-outline-secondary"
                data-dismiss="modal"
            >
                Annuler
            </button>
            <button @click="close(true)" type="button" class="btn btn-primary">
                Confirmer
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'body', 'context'],
    methods: {
        close(value) {
            this.$emit('close', value);
        },
    },
};
</script>
<style scoped>
.modal-default {
    display: flex;
    flex-direction: column;
    width: 400px;
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    padding: 15px;
    z-index: 101;
}
</style>

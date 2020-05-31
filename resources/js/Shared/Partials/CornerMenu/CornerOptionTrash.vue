<template>
    <corner-option-item
        @click.native.prevent="trash"
        :item="{
            link: '',
            iconPath: model.trashed
                ? 'M14,14H16L12,10L8,14H10V18H14V14M6,7H18V19C18,19.5 17.8,20 17.39,20.39C17,20.8 16.5,21 16,21H8C7.5,21 7,20.8 6.61,20.39C6.2,20 6,19.5 6,19V7M19,4V6H5V4H8.5L9.5,3H14.5L15.5,4H19Z'
                : 'M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z',

            text: model.trashed ? 'Restore' : 'Put in the trash'
        }"
    />
</template>

<script>
export default {
    props: ["model"],
    components: {
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem")
    },
    created() {
        console.log(this.$page.account.id);
    },
    methods: {
        trash() {
            this.$inertia.post(
                route("trash.store", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    model: this.model.modelName,
                    modelId: this.model.id
                }
            );
        }
    }
};
</script>

<style></style>

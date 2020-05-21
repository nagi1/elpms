<template>
    <corner-option-item
        @click.native.prevent="archive"
        :item="{
            link: '',
            iconPath:
                'M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z',
            text: model.archived ? 'Unarchive' : 'Archive'
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
        archive() {
            this.$inertia.post(
                route("archive.store", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    model: this.model.modelName,
                    modelId: this.model.id
                },
                {
                    preserveState: false
                }
            );
        }
    }
};
</script>

<style></style>

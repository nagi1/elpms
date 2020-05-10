<template>
    <div class="bg-orange-200 rounded-lg p-3 text-center">
        This {{ model.modelDisplayName }} has been
        <span class="font-bold">archived</span> {{ model.archived }}, You can
        <button @click="archive" class="normal-link">unarchive it</button> or
        <button class="normal-link">put it in the trash</button>.
    </div>
</template>

<script>
export default {
    props: ["model"],

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
                }
            );
        }
    }
};
</script>

<style></style>

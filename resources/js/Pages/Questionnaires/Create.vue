<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            },
            {
                link: route('questionnaires.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Automatic Check-ins'
            }
        ]"
    >
        <div class="w-full h-full py-8 px-20"></div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";

export default {
    components: {
        DoubleWhiteLayout
    },

    props: ["account", "project"],

    data() {
        return {};
    },

    methods: {}
};
</script>

<style></style>

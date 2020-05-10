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
                link: breadcrumbs.index.link,
                text: breadcrumbs.index.text
            },
            {
                link: breadcrumbs.model.link,
                text: breadcrumbs.model.text
            }
        ]"
    >
        <div class="w-full h-full md:py-5 md:px-12 overflow-hidden">
            <div class="md:p-10 flex justify-center space-x-10 items-start">
                <div class="hidden sm:block">
                    <component :data="previewCard" :is="PreviewCardComponent" />
                </div>
                <div class="flex-grow h-64">
                    <h1 class="text-3xl font-bold">
                        Move to this {{ previewCard.modelDisplayName }}
                    </h1>
                    <div class="mt-5 pr-5">
                        <span> Choose where to put this: </span>

                        <select-input
                            class="w-full mt-2"
                            v-model="selectedProject"
                        >
                            <option
                                v-for="project in projects"
                                :key="project.id"
                                :value="project.id"
                                >{{ project.name }}</option
                            >
                        </select-input>

                        <div class="mt-3 flex space-x-1">
                            <LoadingButton
                                class="rounded-full p-3 bg-gray-700 text-gray-200 text-sm font-semibold"
                                type="submit"
                                :loading="loading"
                                @click.native="submit"
                            >
                                Move this to new location
                            </LoadingButton>

                            <inertia-link
                                :href="previewCard.path"
                                class="rounded-full p-3 bg-white border border-gray-700 font-semibold text-sm"
                                type="submit"
                            >
                                Never mind
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import SelectInput from "@/Shared/Components/SelectInput";
import LoadingButton from "@/Shared/LoadingButton";

export default {
    components: {
        DoubleWhiteLayout,
        SelectInput,
        LoadingButton
    },

    props: ["account", "project", "projects", "previewCard", "breadcrumbs"],

    data() {
        return {
            selectedProject: this.projects[0].id,
            loading: false,
            PreviewCardComponent: ""
        };
    },
    created() {
        this.PreviewCardComponent = () =>
            import(
                `@/Shared/PreviewCards/${this.previewCard.modelName}PreviewCard.vue`
            );
    },

    methods: {
        submit() {
            this.loading = true;

            this.$inertia.post(
                route("move.store", {
                    account: this.account.id,
                    project: this.project.id,
                    model: this.previewCard.modelName,
                    modelId: this.previewCard.id
                }),
                {
                    selectedProject: this.selectedProject
                }
            );
        }
    }
};
</script>

<style></style>

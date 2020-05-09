<template>
    <double-white-layout
        :breadcrumps="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            },
            {
                link: breadcrumps.index.link,
                text: breadcrumps.index.text
            },
            {
                link: breadcrumps.model.link,
                text: breadcrumps.model.text
            }
        ]"
    >
        <div class="w-full h-full md:py-5 md:px-12 overflow-hidden">
            <div class="md:p-10 flex justify-center space-x-10 items-start">
                <div class="hidden sm:block">
                    <component :data="previewCard" :is="PreviewCardComponent" />
                </div>
                <div class="flex-grow h-64">
                    <h1 class="text-2xl font-bold">
                        Who should be notified when someone comments on this?
                    </h1>
                    <div class="mt-5 pr-5">
                        <div class="flex items-baseline space-x-1">
                            <button @click="selectAll" class="normal-link">
                                Select everyone
                            </button>
                            <span>&bull;</span>
                            <button @click="selectNone" class="normal-link">
                                Select no one
                            </button>
                        </div>

                        <div class="mt-8 flex flex-col space-y-3">
                            <div
                                v-for="company in SubscribersWithCompanies"
                                :key="company.companyName"
                                class="flex flex-col space-y-3"
                            >
                                <span class="font-semibold text-lg">{{
                                    company.companyName
                                }}</span>
                                <label
                                    :key="user.id"
                                    v-for="user in company.users"
                                    :for="user.id"
                                    class="block pb-2 border-b flex items-center justify-between"
                                >
                                    <div class="flex items-center space-x-2">
                                        <avatar :user="user" size="xsmall" />
                                        <div>
                                            <span class="font-bold">{{
                                                user.name
                                            }}</span
                                            ><span v-if="user.title"
                                                >, {{ user.title }}</span
                                            >
                                        </div>
                                    </div>
                                    <input
                                        type="checkbox"
                                        v-model="selectedUsers"
                                        :value="user.id"
                                        class="form-checkbox h-6 w-6 text-green-500 border border-gray-500"
                                        :id="user.id"
                                    />
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 flex space-x-1">
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
import { groupBy, chain } from "lodash";

export default {
    components: {
        DoubleWhiteLayout,
        SelectInput,
        LoadingButton
    },

    props: ["account", "project", "previewCard", "breadcrumps", "subscribers"],

    data() {
        return {
            loading: false,
            PreviewCardComponent: "",
            selectedUsers: []
        };
    },

    computed: {
        SubscribersWithCompanies() {
            return chain(this.project.subscribers)
                .groupBy("company")
                .map((value, key) => ({
                    companyName: key,
                    users: value
                }))
                .value();
        },
        subscribersIds() {
            return this.subscribers.subscribers.map(user => user.id);
        },
        projectSubscribersId() {
            return this.project.subscribers.map(user => user.id);
        }
    },

    created() {
        this.PreviewCardComponent = () =>
            import(
                `@/Shared/PreviewCards/${this.previewCard.modelName}PreviewCard.vue`
            );

        this.selectedUsers = this.subscribersIds;
    },

    methods: {
        submit() {
            this.loading = true;
        },
        alreadySubscribed(userId) {
            return this.subscribersIds.some(id => id === userId);
        },
        selectNone() {
            this.selectedUsers = [];
        },
        selectAll() {
            this.selectedUsers = this.projectSubscribersId;
        }
    }
};
</script>

<style></style>

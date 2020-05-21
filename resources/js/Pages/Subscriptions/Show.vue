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
                                        <avatar :user="user" size="sm" />
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

                        <div class="mt-10 flex flex-col space-y-2">
                            <label
                                for="dontNotifyNewPeople"
                                class="flex items-center space-x-2"
                            >
                                <input
                                    type="radio"
                                    id="dontNotifyNewPeople"
                                    :value="false"
                                    v-model="notifyNewPeople"
                                    class="form-radio text-gray-800 h-5 w-5 border border-gray-500"
                                />
                                <span class="text-base text-gray-900"
                                    >Don't notify new people until the next
                                    comment is posted
                                </span>
                            </label>
                            <label
                                for="NotifyNewPeople"
                                class="flex items-center space-x-2"
                            >
                                <input
                                    type="radio"
                                    id="NotifyNewPeople"
                                    :value="true"
                                    v-model="notifyNewPeople"
                                    class="form-radio text-gray-800 h-5 w-5 border border-gray-500"
                                />
                                <span class="text-base text-gray-900"
                                    >Send new people the message with all
                                    comments right now
                                </span>
                            </label>
                        </div>

                        <div class="mt-8 flex space-x-1">
                            <LoadingButton
                                class="rounded-full p-3 bg-gray-700 text-gray-200 text-sm font-semibold"
                                type="submit"
                                :loading="loading"
                                @click.native="submit"
                            >
                                Save changes
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
import LoadingButton from "@/Shared/Components/LoadingButton";
import { groupBy, chain } from "lodash";

export default {
    components: {
        DoubleWhiteLayout,
        SelectInput,
        LoadingButton
    },

    props: ["account", "project", "previewCard", "breadcrumbs", "subscribers"],

    data() {
        return {
            loading: false,
            PreviewCardComponent: "",
            selectedUsers: [],
            notifyNewPeople: false
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
                `@/Shared/Partials/PreviewCards/${this.previewCard.modelName}PreviewCard.vue`
            );

        this.selectedUsers = this.subscribersIds;
    },

    methods: {
        submit() {
            this.loading = true;
            this.$inertia.put(
                route("subscription.update", {
                    account: this.account.id,
                    project: this.project.id,
                    model: this.previewCard.modelName,
                    modelId: this.previewCard.id
                }),
                {
                    selectedUsers: this.selectedUsers,
                    notifyNewPeople: this.notifyNewPeople
                }
            );
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

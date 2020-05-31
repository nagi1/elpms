<template>
    <modal @close="close" :open="open">
        <div
            style="max-height:35rem;"
            class="max-w-xl bg-white rounded-lg shadow-2xl px-8 py-6 "
        >
            <h2
                class="font-semibold text-gray-800 text-xl text-center leading-tight"
            >
                Who should be notified?
            </h2>

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
                        v-for="company in usersGroupedByCompany"
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

                <div class="mt-8 flex space-x-1">
                    <button
                        class="rounded-full p-3 bg-gray-700 text-gray-200 text-sm font-semibold"
                        @click.prevent="submit"
                    >
                        Save changes
                    </button>

                    <button
                        class="rounded-full p-3 bg-white border border-gray-700 font-semibold text-sm"
                        @click.prevent="close"
                    >
                        Never mind
                    </button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
import { groupBy, chain } from "lodash";
export default {
    props: ["open", "users"],
    components: {
        Modal: () => import("@/Shared/Partials/Modals/Modal")
    },
    created() {
        this.selectedUsers = this.usersIds;
    },
    data() {
        return {
            selectedUsers: []
        };
    },
    computed: {
        usersGroupedByCompany() {
            return chain(this.users)
                .groupBy("company")
                .map((value, key) => ({
                    companyName: key,
                    users: value
                }))
                .value();
        },
        usersIds() {
            return this.users.map(user => user.id);
        }
    },
    methods: {
        close() {
            this.$emit("close");
        },
        selectNone() {
            this.selectedUsers = [];
        },
        selectAll() {
            this.selectedUsers = this.usersIds;
        },
        submit() {
            this.$emit("input", this.selectedUsers);
            this.close();
        }
    }
};
</script>

<style></style>

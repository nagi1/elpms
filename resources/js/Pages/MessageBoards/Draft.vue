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
                link: route('messageBoards.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Message Board'
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div class="w-full text-center md:border-b-2 border-black pb-4">
                <!-- title -->
                <h1 class="text-3xl font-bold">
                    Message Board Drafts
                </h1>
            </div>

            <div
                class="w-full mt-5 flex justify-center items-center text-center"
            >
                Since you haven’t published these drafts, only you can see them.
            </div>

            <div class="mt-10 md:px-10 flex flex-col space-y-4">
                <inertia-link
                    v-for="messageBoard in messageBoards"
                    :key="messageBoard.id"
                    class="block flex justify-between border-b pb-3 overflow-x-hidden"
                    :href="
                        route('messageBoards.draft.show', {
                            account: account,
                            project: project,
                            messageBoard: messageBoard.id
                        })
                    "
                >
                    <div class="leading-6">
                        <h2 class="font-bold text-lg tracking-wide">
                            {{ messageBoard.title }}
                        </h2>
                        <div class=" text-sm text-yellow-900 opacity-75 ">
                            <span v-if="messageBoard.category">{{
                                messageBoard.category.fullName
                            }}</span>
                            <span
                                >Last edited {{ messageBoard.updated_at }}</span
                            >
                            &minus;
                            <span
                                v-if="messageBoard.excerpt"
                                class="text-black text-base truncate"
                                >&ldquo;{{ messageBoard.excerpt }}&rdquo;</span
                            >
                        </div>
                    </div>
                    <div class="self-end">
                        <button
                            @click.prevent="remove(messageBoard.id)"
                            class="active:text-gray-500 hover:text-gray-500 p-1 bg-white rounded-full border border-gray-700"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6"
                                version="1.1"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
                                />
                            </svg>
                        </button>
                    </div>
                </inertia-link>
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import SelectInput from "@/Shared/Components/SelectInput";

export default {
    components: {
        DoubleWhiteLayout,
        SelectInput
    },

    props: ["account", "project", "messageBoards"],

    data() {
        return {};
    },

    methods: {
        remove(id) {
            if (confirm("Are you sure you want to delete that draft?")) {
                this.$inertia.delete(
                    route("messageBoards.draft.delete", {
                        account: this.account,
                        project: this.project,
                        messageBoard: id
                    }),
                    {
                        preserveState: true
                    }
                );
            }
        }
    }
};
</script>

<style></style>

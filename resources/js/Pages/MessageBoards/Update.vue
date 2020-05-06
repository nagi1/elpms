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
                link: route('messageBoards.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Message Board'
            },
            {
                link: route('messageBoards.show', {
                    account: account.id,
                    project: project.id,
                    messageBoard: messageBoard.id
                }),
                text: messageBoard.title
            }
        ]"
    >
        <div class="w-full h-full sm:py-8 px-20">
            <form
                :action="action"
                method="post"
                ref="formElement"
                class="flex flex-col items-start justify-between h-full"
                enctype="multipart/form-data"
            >
                <input name="_method" type="hidden" value="PUT" />
                <input type="hidden" name="_token" :value="csrf" />
                <div>
                    <div class="inline-block relative w-64">
                        <select
                            ref="category"
                            name="category"
                            class="block appearance-none w-full bg-white border-2 border-gray-800 hover:border-gray-500 px-2 py-2 rounded-full shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option value="" disabled selected
                                >Pick a category (optional)</option
                            >
                            <option
                                v-for="category in project.categories"
                                :value="category.id"
                                :selected="
                                    messageBoard.category
                                        ? category.id ==
                                          messageBoard.category.id
                                        : false
                                "
                                :key="category.id"
                                >{{ category.fullName }}</option
                            >
                            <option @click="openEditCategories"
                                >Edit categories</option
                            >
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                        >
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-5">
                        <input
                            type="text"
                            :value="messageBoard.title"
                            name="title"
                            class="w-full text-4xl placeholder-gray-800 px-2 font-bold h-12"
                            placeholder="Type a title..."
                        />

                        <div class="mt-5" v-html="trix"></div>
                    </div>
                </div>

                <div class="mt-3 flex flex-col space-y-3">
                    <LoadingButton
                        class="rounded-full w-32 text-center p-3 bg-gray-700 text-gray-200 text-sm font-semibold"
                        type="submit"
                    >
                        Save changes
                    </LoadingButton>

                    <div>
                        <span
                            >or,
                            <inertia-link
                                class="normal-link"
                                :href="
                                    route('messageBoards.show', {
                                        account: account.id,
                                        project: project.id,
                                        messageBoard: messageBoard.id
                                    })
                                "
                                >Discard my changes</inertia-link
                            ></span
                        >
                    </div>
                </div>
            </form>
        </div>

        <modal @close="close" :open="editCategories">
            <edit-project-categories :account="account" :project="project" />
        </modal>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import LoadingButton from "@/Shared/LoadingButton";
import Modal from "@/Shared/Components/Modal";
import EditProjectCategories from "@/Shared/EditProjectCategories";

export default {
    components: {
        DoubleWhiteLayout,
        LoadingButton,
        Modal,
        EditProjectCategories
    },

    props: ["account", "project", "trix", "messageBoard"],

    data() {
        return {
            action: route("messageBoards.update", {
                account: this.account.id,
                project: this.project.id,
                messageBoard: this.messageBoard.id
            }),
            csrf: window.csrf,
            editCategories: false
        };
    },
    mounted() {
        document
            .querySelector("trix-editor")
            .classList.add("h-84", "border-none");
    },
    methods: {
        openEditCategories() {
            this.$refs.category.value = "";
            this.editCategories = true;
        },
        close() {
            this.editCategories = false;
        }
    }
};
</script>

<style></style>

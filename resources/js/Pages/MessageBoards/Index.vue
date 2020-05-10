<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            }
        ]"
    >
        <corner-options-menu>
            <inertia-link
                href="#"
                class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-6"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M17,18L12,15.82L7,18V5H17M17,3H7A2,2 0 0,0 5,5V21L12,18L19,21V5C19,3.89 18.1,3 17,3Z"
                    />
                </svg>
                <span class="font-medium">Bookmark</span>
            </inertia-link>

            <a
                href=""
                @click.prevent="sortMessages = true"
                class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-6"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path d="M3 11H15V13H3M3 18V16H21V18M3 6H9V8H3Z" />
                </svg>
                <span class="font-medium">Sort messages by...</span>
            </a>

            <a
                href=""
                @click.prevent="editCategories = true"
                class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-6"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"
                    />
                </svg>
                <span class="font-medium">Edit categories...</span>
            </a>
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-between md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <h1 class="text-3xl font-bold md:hidden">Message Board</h1>
                <div
                    class="w-full justify-center flex space-x-2 md:space-x-0 md:justify-between items-center mt-3"
                >
                    <!-- button -->
                    <a
                        class="flex items-center rounded-full py-2 px-3 bg-gray-700 text-white text-sm  space-x-1"
                        :href="
                            route('messageBoards.create', {
                                account: $page.account.id,
                                project: $page.project.id
                            })
                        "
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-5"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z"
                            />
                        </svg>
                        <span class="tracking-tight">New message</span>
                    </a>
                    <!-- title -->
                    <h1 class="text-3xl hidden md:block font-bold">
                        Message Board
                    </h1>
                    <!-- select -->
                    <select-input class="w-40" v-model="selectedCategory">
                        <option value="" selected>All Messages</option>
                        <option
                            v-for="category in project.categories"
                            :key="category.id"
                            :value="category.id"
                            >{{ category.fullName }}</option
                        >
                    </select-input>
                </div>
            </div>

            <div
                class="w-full mt-5 flex justify-center items-center text-center"
            >
                <inertia-link
                    v-if="draftsCount > 0"
                    class="normal-link leading-5 tracking-wide text-sm"
                    :href="
                        route('messageBoards.draft.index', {
                            account: account.id,
                            project: project.id
                        })
                    "
                >
                    Continue writing {{ draftsCount }} drafts…
                </inertia-link>
            </div>

            <div class="mt-10 md:px-10 flex flex-col space-y-4">
                <div
                    v-for="messageBoard in messageBoards"
                    :key="messageBoard.id"
                    class="block flex justify-between items-center border-b pb-3 overflow-x-hidden"
                >
                    <div class="flex space-x-2 flex-grow">
                        <avatar-modal size="base" :user="messageBoard.user" />

                        <a
                            :href="
                                route('messageBoards.show', {
                                    account: account.id,
                                    project: project.id,
                                    messageBoard: messageBoard.id
                                })
                            "
                            class="leading-6 flex-grow "
                        >
                            <h2 class="font-bold text-lg tracking-wide">
                                {{ messageBoard.title }}
                            </h2>
                            <div class=" text-sm text-yellow-900 opacity-75 ">
                                <span v-if="messageBoard.category"
                                    >{{
                                        messageBoard.category.fullName
                                    }}
                                    by</span
                                >
                                <span>{{ messageBoard.user.name }}</span> &bull;
                                <span>{{ messageBoard.shortDate }}</span>
                                &minus;
                                <span
                                    v-if="messageBoard.excerpt"
                                    class="text-black text-base truncate"
                                    >&ldquo;{{
                                        messageBoard.excerpt
                                    }}&rdquo;</span
                                >
                            </div>
                        </a>
                    </div>
                    <span
                        v-if="messageBoard.commentsCount > 0"
                        class="bg-gray-700  text-white font-bold flex items-center justify-center text-lg p-3 h-8 w-8 rounded-full"
                        >{{ messageBoard.commentsCount }}</span
                    >
                </div>
            </div>

            <div
                class="w-full mt-5 flex justify-center items-center text-center"
            >
                <inertia-link
                    v-if="archivedCount > 0"
                    class="leading-5 tracking-wide text-sm flex space-x-1 items-center"
                    :href="
                        route('messageBoards.archive', {
                            account: account.id,
                            project: project.id
                        })
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z"
                        />
                    </svg>

                    <span class="font-semibold"
                        >{{ archivedCount }} archived messages</span
                    >
                </inertia-link>
            </div>
        </div>
        <modal @close="editCategories = false" :open="editCategories">
            <edit-project-categories :account="account" :project="project" />
        </modal>

        <modal @close="sortMessages = false" :open="sortMessages">
            <sort-messages-modal
                @close="sortMessages = false"
                :currentSortMethod="project.MessageBoardMeta.sortBy"
            />
        </modal>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import SelectInput from "@/Shared/Components/SelectInput";
import CornerOptionsMenu from "@/Shared/CornerOptionsMenu";
import Modal from "@/Shared/Components/Modal";
import EditProjectCategories from "@/Shared/EditProjectCategories";
import SortMessagesModal from "@/Shared/SortMessagesModal";

export default {
    components: {
        DoubleWhiteLayout,
        SelectInput,
        CornerOptionsMenu,
        Modal,
        EditProjectCategories,
        SortMessagesModal
    },

    props: [
        "account",
        "project",
        "messageBoards",
        "categoryFilter",
        "draftsCount",
        "archivedCount"
    ],

    data() {
        return {
            selectedCategory: this.categoryFilter,
            editCategories: false,
            sortMessages: false
        };
    },
    watch: {
        selectedCategory(categoryId) {
            const params = categoryId ? { categoryId } : { remember: "forget" };
            this.$inertia.replace(
                route("messageBoards.index", {
                    account: this.account.id,
                    project: this.project.id,
                    ...params
                })
            );
        }
    },
    methods: {}
};
</script>

<style></style>

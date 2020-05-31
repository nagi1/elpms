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
                link: route('todoLists.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'To-dos'
            },
            {
                condition: todoList.archived,
                link: route('todoLists.archive', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Archived To-dos'
            }
        ]"
    >
        <corner-options-menu>
            <corner-option-archive :model="todoList" />
            <corner-option-trash :model="todoList" />
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-20 overflow-hidden">
            <archived-status-card
                v-if="todoList.archived"
                :model="todoList"
                class="mb-10"
            />

            <todo-list-item :todoList="todoList" mode="singleView" />

            <div
                class="w-full mt-5 border-t border-gray-300 pt-5 px-5 flex justify-start items-center"
            >
                <inertia-link
                    v-if="archivedCount > 0"
                    class="leading-5 tracking-wide text-sm flex space-x-1 items-center"
                    :href="
                        route('todoItems.archive', {
                            account: account.id,
                            project: project.id,
                            todoList: todoList.id
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

                    <span>{{ archivedCount }} archived to-dos</span>
                </inertia-link>
            </div>

            <div class="mt-10">
                <boosts
                    :boosts="todoList.boosts"
                    :model="todoList.modelName"
                    :modelId="todoList.id"
                />
            </div>

            <comment-section
                :model="todoList.modelName"
                :modelId="todoList.id"
                :comments="todoList.comments"
                :commentsCount="todoList.commentsCount"
                :trix="commentsTrix"
            />

            <div class="mt-10 sm:px-10 px-5 pt-5 border-t">
                <subscribe-section
                    :subscribers="todoList.subscribers"
                    :model="todoList.modelName"
                    :modelId="todoList.id"
                />
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";

import LoadingButton from "@/Shared/Components/LoadingButton";
import CommentSection from "@/Shared/Partials/Comments/CommentSection";
import Boosts from "@/Shared/Partials/Boosts/Boosts";
import ArchivedStatusCard from "@/Shared/Components/ArchivedStatusCard";

export default {
    components: {
        DoubleWhiteLayout,

        LoadingButton,
        CommentSection,
        Boosts,
        ArchivedStatusCard,
        SubscribeSection: () =>
            import("@/Shared/Partials/Subscriptions/SubscribeSection"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu"),
        CornerOptionArchive: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionArchive"),
        CornerOptionTrash: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionTrash"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        TodoListItem: () => import("@/Shared/Partials/TodoLists/TodoListItem")
    },

    props: [
        "account",
        "project",
        "todoList",
        "commentsTrix",
        "archivedCount",
        "todoItemTrix"
    ]
};
</script>

<style></style>

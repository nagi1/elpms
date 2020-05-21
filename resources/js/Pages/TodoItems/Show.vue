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
                link: route('todoLists.show', {
                    account: account.id,
                    project: project.id,
                    todoList: todoList.id
                }),
                text: todoList.name
            },
            {
                condition: todoItem.archived,
                link: route('todoItems.archive', {
                    account: account.id,
                    project: project.id,
                    todoList: todoList.id
                }),
                text: 'Archived Todo items'
            }
        ]"
    >
        <corner-options-menu>
            <corner-option-item
                @click.native="edit = true"
                :item="{
                    type: 'a',
                    text: 'Edit',
                    iconPath:
                        'M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z'
                }"
            />
            <corner-option-archive :model="todoItem" />
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-20 overflow-hidden">
            <archived-status-card
                v-if="todoItem.archived"
                :model="todoItem"
                class="mb-10"
            />

            <div v-if="!edit" class="content">
                <div class="flex justify-start px-5 sm:px-10">
                    <div
                        class="flex items-center flex-grow space-x-3 border-b border-gray-400 pb-4"
                    >
                        <label
                            class="flex flex-col space-y-3 items-center"
                            for="completed"
                        >
                            <input
                                type="checkbox"
                                class="form-checkbox text-green-500 shadow-lg rounded-lg focus:shadow-outline border-gray-400 w-16 h-16"
                                :disabled="archived"
                                @change="mark"
                                v-model="completed"
                                id="completed"
                            />
                            <span
                                class="text-sm font-bold select-none cursor-pointer"
                                >{{
                                    completed ? "Reopen?" : "Completed?"
                                }}</span
                            >
                        </label>

                        <div class="leading-7">
                            <h1 class="text-2xl font-bold">
                                {{ todoItem.description }}
                            </h1>
                            <span class="text-sm"
                                >Created by {{ todoItem.user.name }}
                                {{ todoItem.createdAt }}</span
                            >
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col  divide-y divide-gray-200 px-5 sm:px-10 mt-5"
                >
                    <div
                        class="flex flex-grow space-x-3 py-3 justify-start items-center"
                    >
                        <span
                            class="w-40 text-left  sm:text-right font-semibold"
                            >Assigned to</span
                        >
                        <div class="flex-grow flex space-x-1 items-center">
                            <avatar-label
                                v-for="user in todoItem.assignedTo"
                                :key="user.id"
                                :user="user"
                            />
                            <span
                                class="text-gray-500 cursor-pointer"
                                @click="edit = true"
                                v-if="!todoItem.assignedTo.length"
                                >Type names to assign...</span
                            >
                        </div>
                    </div>
                    <div
                        class="flex flex-grow space-x-3 py-3  justify-start items-center"
                    >
                        <span
                            class="w-40 text-left  sm:text-right font-semibold"
                        >
                            When done, notify</span
                        >
                        <div class="flex-grow flex space-x-1 items-center">
                            <avatar-label
                                v-for="user in todoItem.whenDoneNotify"
                                :key="user.id"
                                :user="user"
                            />
                            <span
                                class="text-gray-500 cursor-pointer"
                                @click="edit = true"
                                v-if="!todoItem.whenDoneNotify.length"
                                >Type names to notify...</span
                            >
                        </div>
                    </div>
                    <div
                        class="flex flex-grow space-x-3 py-3  justify-start items-center"
                    >
                        <span
                            class="w-40 text-left  sm:text-right font-semibold"
                        >
                            Due on</span
                        >
                        <div class="flex-grow flex space-x-1 items-center">
                            <button
                                v-if="todoItem.endsAt"
                                @click="edit = true"
                                class="flex items-center space-x-1"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="fill-green-500 h-6 w-6"
                                    version="1.1"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"
                                    />
                                </svg>
                                <span v-if="todoItem.startsAt"
                                    >{{ todoItem.startsAt }} -
                                </span>
                                <span> {{ todoItem.endsAt }}</span>
                            </button>

                            <span
                                class="text-gray-500 cursor-pointer"
                                @click="edit = true"
                                v-if="!todoItem.endsAt"
                                >Select a date...</span
                            >
                        </div>
                    </div>
                    <div
                        class="flex flex-grow space-x-3 py-3 justify-start items-center"
                    >
                        <span
                            class="w-40 text-left  sm:text-right font-semibold"
                            >Notes</span
                        >
                        <div class="flex-grow flex space-x-1 items-center">
                            <div v-html="todoItem.trixRichText"></div>
                            <span
                                class="text-gray-500 cursor-pointer"
                                @click="edit = true"
                                v-if="!todoItem.trixRichText"
                                >Add extra details or attach file...</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <collapse-transition :duration="200">
                <todo-item-form
                    :users="project.users"
                    :todoList="todoList"
                    :trix="todoItemTrix"
                    mode="edit"
                    v-if="edit"
                    :todoItem="todoItem"
                    @closed="edit = false"
                />
            </collapse-transition>

            <div class="mt-10">
                <boosts
                    :boosts="todoItem.boosts"
                    :model="todoItem.modelName"
                    :modelId="todoItem.id"
                />
            </div>

            <event-section
                :model="todoItem.modelName"
                :events="todoItem.events"
            />

            <comment-section
                :model="todoItem.modelName"
                :modelId="todoItem.id"
                :comments="todoItem.comments"
                :commentsCount="todoItem.commentsCount"
                :trix="commentsTrix"
            />

            <div class="mt-10 sm:px-10 px-5 pt-5 border-t">
                <subscribe-section
                    :subscribers="todoItem.subscribers"
                    :model="todoItem.modelName"
                    :modelId="todoItem.id"
                />
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import CommentSection from "@/Shared/Partials/Comments/CommentSection";
import Boosts from "@/Shared/Partials/Boosts/Boosts";
import ArchivedStatusCard from "@/Shared/Components/ArchivedStatusCard";
import { CollapseTransition } from "vue2-transitions";

export default {
    components: {
        DoubleWhiteLayout,
        CollapseTransition,
        CommentSection,
        Boosts,
        ArchivedStatusCard,
        AvatarLabel: () => import("@/Shared/Partials/User/AvatarLabel"),
        TodoItemForm: () => import("@/Shared/Partials/TodoLists/TodoItemForm"),

        SubscribeSection: () =>
            import("@/Shared/Partials/Subscriptions/SubscribeSection"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu"),
        CornerOptionArchive: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionArchive"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        TodoListItem: () => import("@/Shared/Partials/TodoLists/TodoListItem"),
        EventSection: () => import("@/Shared/Partials/Events/EventSection")
    },

    props: [
        "account",
        "project",
        "todoList",
        "todoItem",
        "commentsTrix",
        "todoItemTrix"
    ],
    data() {
        return {
            completed: Boolean(this.todoItem.completed),
            archived: Boolean(this.todoItem.archived),
            edit: false
        };
    },
    methods: {
        mark() {
            this.$inertia.put(
                route("todoItems.mark", {
                    account: this.account.id,
                    project: this.project.id,
                    todoList: this.todoList.id,
                    todoItem: this.todoItem.id
                }),
                {
                    completed: this.completed
                },
                {
                    preserveState: false,
                    replace: true
                }
            );
        }
    }
};
</script>

<style></style>

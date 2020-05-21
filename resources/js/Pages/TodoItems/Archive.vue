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
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-center md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <div class="flex flex-col space-y-2">
                    <h1 class="text-3xl font-bold">Archived To-dos</h1>
                    <div class="text-center text-sm ">
                        From list:
                        <inertia-link
                            :href="
                                route('todoLists.show', {
                                    account: account.id,
                                    project: project.id,
                                    todoList: todoList.id
                                })
                            "
                            class="normal-link"
                            >{{ todoList.name }}</inertia-link
                        >
                    </div>
                </div>
            </div>

            <div class="mt-5 px-10">
                <archived-todoItem
                    v-for="todoItem in todoItems"
                    :key="todoItem.id"
                    :todoItem="todoItem"
                />
            </div>

            <div class="mt-10 md:px-10 flex flex-col space-y-4"></div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";

export default {
    components: {
        DoubleWhiteLayout,
        ArchivedTodoItem: () =>
            import("@/Shared/Partials/TodoItems/ArchivedTodoItem")
    },

    props: ["account", "project", "todoList", "todoItems"]
};
</script>

<style></style>

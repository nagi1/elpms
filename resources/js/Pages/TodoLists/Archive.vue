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
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-center md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <h1 class="text-3xl font-bold">Archived To-do Lists</h1>
            </div>

            <div class="mt-5 px-10">
                <archived-todo-list-item
                    :key="todoList.id"
                    v-for="todoList in todoLists"
                    :todoList="todoList"
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
        ArchivedTodoListItem: () =>
            import("@/Shared/Partials/TodoLists/ArchivedTodoListItem")
    },

    props: ["account", "project", "todoLists"]
};
</script>

<style></style>

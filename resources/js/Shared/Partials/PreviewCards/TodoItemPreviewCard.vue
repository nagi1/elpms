<template>
    <inertia-link
        :href="data.path"
        class="border border-gray-400 shadow-md rounded p-5 w-48 h-64 flex flex-col space-y-2"
    >
        <div class="flex flex-col space-y-2 mt-3 h-full overflow-hidden">
            <div class="todoList flex flex-col space-y-2">
                <span class="text-sm font-semibold">{{
                    data.todoList.name
                }}</span>
                <todo-item-small :todoItem="data" />
            </div>
        </div>
    </inertia-link>
</template>

<script>
export default {
    name: "TodoItemPreviewCard",
    components: {
        todoItemSmall: () => import("@/Shared/Partials/TodoItems/TodoItemSmall")
    },
    props: ["data"]
};
</script>

<style></style>

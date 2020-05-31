<template>
    <div class="flex flex-col space-y-1">
        <h3 class="font-bold text-sm leading-5">
            On
            <inertia-link
                class="normal-link"
                :href="activityData.data.todoList.path"
                >{{ activityData.data.todoList.name }}</inertia-link
            >
            {{ activityData.user.name }} added
        </h3>
        <todo-item-small :todoItem="activityData.data" />
    </div>
</template>

<script>
export default {
    name: "CreateTodoItemActivityCard",
    props: ["activityData"],
    components: {
        todoItemSmall: () => import("@/Shared/Partials/TodoItems/TodoItemSmall")
    }
};
</script>

<style></style>

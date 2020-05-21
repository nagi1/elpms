<template>
    <div class="flex flex-col space-y-3">
        <div class="p-1 flex items-center justify-start space-x-2">
            <div class="flex items-center space-x-2">
                <pie-chart
                    :percent="piePercentage"
                    :stroke-width="10"
                    label=" "
                    label-small=" "
                    color="#2da562"
                    outerColor="#96d2b1"
                    class="self-end h-6 w-6"
                    :opacity="0.7"
                />
                <div class="leading-5">
                    <span class="leading-5 block text-xs tracking-wide"
                        >{{ todoList.archivedCompletedTodoItemsCount }}/{{
                            todoList.archivedTodoItemsCount
                        }}
                        completed</span
                    >

                    <inertia-link
                        :href="todoList.path"
                        class="block normal-link text-lg font-semibold mt-1"
                        >{{ todoList.name }}</inertia-link
                    >
                </div>
            </div>
        </div>
        <div class="pt-3 mx-5" v-html="todoList.excerpt"></div>
        <div class="flex flex-col space-y-3 ">
            <archived-todo-item
                v-for="todoItem in todoList.todoItems"
                :key="todoItem.id"
                :todoItem="todoItem"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["todoItem"],
    components: {
        ArchivedTodoItem: () =>
            import("@/Shared/Partials/TodoItems/ArchivedTodoItem"),
        PieChart: () => import("@/Shared/Components/PieChart")
    },
    props: ["todoList"],
    computed: {
        piePercentage() {
            if (this.todoList.archivedTodoItemsCount === 0) {
                return 0;
            }

            return (
                (this.todoList.archivedCompletedTodoItemsCount /
                    this.todoList.archivedTodoItemsCount) *
                100
            );
        }
    }
};
</script>

<template>
    <inertia-link
        :href="data.path"
        class="border border-gray-400 shadow-md rounded p-5 w-48 h-64 flex flex-col space-y-2"
    >
        <div class="flex flex-col space-y-2 mt-3 h-full overflow-hidden">
            <div class="todoList flex flex-col space-y-2">
                <div class="flex items-center space-x-2">
                    <!-- #96d2b1 -->
                    <pie-chart
                        :percent="piePercentage"
                        :stroke-width="10"
                        label=" "
                        label-small=" "
                        :color="data.color"
                        :outerColor="lightenColor(data.color, 50)"
                        class="self-end h-5 w-5"
                        :opacity="0.7"
                    />
                    <div class="leading-5">
                        <span class="text-xs tracking-wide leading-5 block"
                            >{{ data.completedTodoItemsCount }}/{{
                                data.todoItemsCount
                            }}
                            completed</span
                        >

                        <inertia-link
                            :href="data.path"
                            class="block normal-link text-lg font-semibold mt-1"
                            >{{ data.name }}</inertia-link
                        >
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <todo-item-small
                        v-for="todoItem in data.todoItemsSummary"
                        :key="todoItem.id"
                        :todoItem="todoItem"
                    />
                </div>
            </div>
        </div>
    </inertia-link>
</template>

<script>
export default {
    name: "TodoListPreviewCard",
    components: {
        todoItemSmall: () =>
            import("@/Shared/Partials/TodoItems/TodoItemSmall"),
        PieChart: () => import("@/Shared/Components/PieChart")
    },
    props: ["data"],
    computed: {
        piePercentage() {
            if (this.data.todoItemsCount === 0) {
                return 0;
            }

            return (
                (this.data.completedTodoItemsCount / this.data.todoItemsCount) *
                100
            );
        }
    }
};
</script>

<style></style>

<template>
    <bucket-card :link="link" name="To-dos">
        <div
            v-if="empty"
            class="flex flex-col justify-center items-center mt-1 h-full"
        >
            <div class="flex flex-col justify-center items-center h-full">
                <div
                    class="rounded-full sm:h-20 sm:w-20 h-24 w-24 flex items-center justify-center bg-green-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        class="fill-current text-white sm:h-12 h-16"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"
                        />
                    </svg>
                </div>
                <p
                    class="mt-3 hidden sm:block text-center text-sm leading-tight"
                >
                    Make lists of work that needs to get done, assign items, set
                    due dates, and discuss.
                </p>
            </div>
        </div>
        <div class="flex flex-col space-y-2 mt-3 h-full overflow-hidden" v-else>
            <div
                v-for="todoList in todoLists"
                :key="todoList.id"
                class="todoList flex flex-col space-y-1"
            >
                <span class="font-semibold truncate text-xs">{{
                    todoList.name
                }}</span>
                <div class="flex flex-col space-y-2">
                    <todo-item-small
                        v-for="todoItem in todoList.todoItemsSummary"
                        :key="todoItem.id"
                        :todoItem="todoItem"
                    />
                </div>
            </div>
        </div>
    </bucket-card>
</template>

<script>
import BucketCard from "@/Shared/Components/BucketCard";
export default {
    components: {
        BucketCard,
        todoItemSmall: () => import("@/Shared/Partials/TodoItems/TodoItemSmall")
    },
    props: ["todoLists", "link"],
    computed: {
        empty() {
            return this.todoLists.length === 0;
        }
    }
};
</script>

<style></style>

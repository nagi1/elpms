<template>
    <div class="relative flex flex-col space-y-3">
        <corner-options-menu
            v-if="!showEditList && !singleView"
            buttonSize="h-4"
            top="mt-3"
        >
            <corner-option-archive :model="todoList" />
            <corner-option-item
                @click.native.prevent="openEdit"
                :item="{
                    type: 'a',
                    link: '',
                    iconPath:
                        'M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z',
                    text: 'Edit'
                }"
            />
        </corner-options-menu>
        <collapse-transition :duration="200">
            <todo-list-form
                @closed="showEditList = false"
                v-if="showEditList"
                mode="edit"
                :todoList="todoList"
                :trix="$page.trix"
            />
        </collapse-transition>
        <div
            v-if="!showEditList"
            class="p-1  flex items-center justify-start space-x-2"
        >
            <dragging-handler v-if="!singleView" />

            <div class="flex items-center space-x-2">
                <!-- #96d2b1 -->
                <pie-chart
                    :percent="archived ? archivedPiePercentage : piePercentage"
                    :stroke-width="10"
                    label=" "
                    label-small=" "
                    :color="todoList.color"
                    :outerColor="lightenColor(todoList.color, 50)"
                    class="self-end"
                    :class="{
                        'h-6 w-6': !singleView,
                        'h-8 w-8': singleView
                    }"
                    :opacity="0.7"
                />
                <div class="leading-5">
                    <span
                        :class="{
                            'text-xs tracking-wide': !singleView,
                            'text-lg opacity-75': singleView
                        }"
                        class="leading-5 block"
                        >{{
                            archived
                                ? todoList.archivedCompletedTodoItemsCount
                                : todoList.completedTodoItemsCount
                        }}/{{
                            archived
                                ? todoList.archivedTodoItemsCount
                                : todoList.todoItemsCount
                        }}
                        completed</span
                    >

                    <inertia-link
                        :href="todoList.path"
                        class="block "
                        :class="{
                            'normal-link text-lg font-semibold mt-1': !singleView,
                            'text-3xl font-bold mt-2': singleView
                        }"
                        >{{ todoList.name }}</inertia-link
                    >
                </div>
            </div>
        </div>
        <div
            class="pt-3 mx-5"
            v-if="singleView"
            v-html="todoList.trixRichText"
        ></div>
        <div v-if="!showEditList" class="flex flex-col space-y-3 ">
            <todoItem
                v-for="todoItem in completedItems"
                :key="todoItem.id"
                :todoItem="todoItem"
            />
            <draggable
                tag="div"
                :list="dragList"
                class=""
                draggable=".draggable-todoItem"
                handle=".todoItem-handler"
                v-bind="dragOptions"
                @update="onUpdate"
            >
                <todoItem
                    v-for="todoItem in dragList"
                    :key="todoItem.id"
                    :todoItem="todoItem"
                />
            </draggable>
        </div>

        <collapse-transition :duration="200">
            <todo-item-form
                :users="$page.project.users"
                :todoList="todoList"
                :trix="$page.todoItemTrix"
                v-if="showAddTodoForm"
                @closed="showAddTodoForm = false"
            />

            <button
                @click="showAddTodoForm = true"
                v-if="!showAddTodoForm && !showEditList"
                class="drag-hidden flex w-32 text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white mx-3 py-2 px-3"
            >
                <span class="text-sm">Add a to-do</span>
            </button>
        </collapse-transition>
    </div>
</template>

<script>
import { CollapseTransition } from "vue2-transitions";
export default {
    props: ["todoItem"],
    components: {
        CollapseTransition,
        TodoItemForm: () => import("@/Shared/Partials/TodoItems/TodoItemForm"),
        TodoListForm: () => import("@/Shared/Partials/TodoLists/TodoListForm"),
        TodoItem: () => import("@/Shared/Partials/TodoItems/TodoItem"),
        DraggingHandler: () => import("@/Shared/Components/DraggingHandler"),

        PieChart: () => import("@/Shared/Components/PieChart"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu"),
        CornerOptionArchive: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionArchive"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        draggable: () => import("vuedraggable")
    },
    props: ["todoList", "mode"],
    data() {
        return {
            archived: Boolean(this.todoList.archived),
            singleView: this.mode === "singleView",
            showAddTodoForm: false,
            showEditList: false,
            dragList: this.todoList.todoItems.filter(item => !item.completed),
            completedItems: this.todoList.todoItems.filter(
                item => item.completed
            )
        };
    },

    methods: {
        openEdit() {
            this.showEditList = true;
            this.showAddTodoForm = false;
        },
        onUpdate(event) {
            setTimeout(() => {
                this.$inertia.put(
                    route("todoItems.sort", {
                        account: this.$page.account.id,
                        project: this.$page.project.id,
                        todoList: this.todoList.id
                    }),
                    {
                        newSort: this.dragList.map(item => item.id)
                    },
                    {
                        replace: true,
                        preserveScroll: true
                    }
                );
            }, 1000);
        }
    },
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "TodoItems",
                ghostClass: "ghost"
            };
        },

        archivedPiePercentage() {
            if (this.todoList.archivedTodoItemsCount === 0) {
                return 0;
            }

            return (
                (this.todoList.archivedCompletedTodoItemsCount /
                    this.todoList.archivedTodoItemsCount) *
                100
            );
        },

        piePercentage() {
            if (this.archived) {
                archivedPiePercentage();
                return;
            }

            if (this.todoList.todoItemsCount === 0) {
                return 0;
            }

            return (
                (this.todoList.completedTodoItemsCount /
                    this.todoList.todoItemsCount) *
                100
            );
        }
    }
};
</script>

<style scoped>
.ghost {
    box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, 0.1),
        0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border-radius: 0.25rem;
    background-color: rgb(243, 243, 243);
    border-width: 1px;
    opacity: 0.75;
    padding: 0.75rem;
}
</style>

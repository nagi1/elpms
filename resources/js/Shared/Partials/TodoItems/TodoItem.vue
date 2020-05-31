<template>
    <div :class="{ 'draggable-todoItem': !completed }">
        <collapse-transition :duration="200">
            <div v-if="!showEdit">
                <div
                    class="relative flex flex-wrap space-y-1 items-center space-x-2 py-2 group"
                >
                    <corner-options-menu
                        v-if="!showEdit"
                        buttonSize="h-4"
                        top="mt-3"
                    >
                        <corner-option-archive :model="todoItem" />
                        <corner-option-item
                            @click.native.prevent="openEdit"
                            :item="{
                                type: 'a',
                                iconPath:
                                    'M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z',
                                text: 'Edit'
                            }"
                        />
                    </corner-options-menu>

                    <dragging-handler
                        v-if="!completed"
                        name="todoItem-handler"
                    />

                    <input
                        type="checkbox"
                        @change="mark"
                        v-model="completed"
                        :title="
                            completed ? `Completed ${todoItem.completed}` : ''
                        "
                        class="form-checkbox cursor-pointer h-6 w-6 text-green-500 border-gray-500"
                    />

                    <inertia-link :href="todoItem.path">{{
                        todoItem.description
                    }}</inertia-link>

                    <inertia-link
                        v-if="todoItem.excerpt"
                        :href="todoItem.path"
                        :title="todoItem.excerpt"
                        ><img
                            class=" h-6 w-6"
                            src="@/assets/icons/note.svg"
                            :alt="todoItem.excerpt"
                    /></inertia-link>

                    <button
                        v-if="todoItem.endsAt"
                        class="flex items-center space-x-1"
                        @click="openEdit"
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

                    <avatar-label
                        v-for="user in todoItem.assignedTo"
                        :key="user.id"
                        :user="user"
                    />

                    <span
                        @click="openEdit"
                        class="cursor-pointer mx-1 hidden group-hover:block transition transition-all duration-200 ease-in-out"
                        v-if="
                            !todoItem.assignedTo.length && !todoItem.completed
                        "
                        >Assign</span
                    >
                    <span
                        @click="openEdit"
                        class="cursor-pointer mx-1 hidden group-hover:block transition transition-all duration-200 ease-in-out"
                        v-if="!todoItem.endsAt && !todoItem.completed"
                        >Schedule</span
                    >
                </div>
            </div>
        </collapse-transition>
        <collapse-transition :duration="200">
            <div v-if="showEdit">
                <todo-item-form
                    :users="$page.project.users"
                    :todoList="todoItem.todoList"
                    :trix="$page.todoItemTrix"
                    mode="edit"
                    :todoItem="todoItem"
                    @closed="showEdit = false"
                />
            </div>
        </collapse-transition>
    </div>
</template>

<script>
import { CollapseTransition } from "vue2-transitions";
export default {
    props: ["todoItem"],
    components: {
        CollapseTransition,
        DraggingHandler: () => import("@/Shared/Components/DraggingHandler"),
        TodoItemForm: () => import("@/Shared/Partials/TodoItems/TodoItemForm"),

        AvatarLabel: () => import("@/Shared/Partials/User/AvatarLabel"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu"),
        CornerOptionArchive: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionArchive"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem")
    },
    data() {
        return {
            showEdit: false,
            completed: Boolean(this.todoItem.completed)
        };
    },

    methods: {
        openEdit() {
            if (this.todoItem.completed) {
                this.showEdit = false;
                return;
            }

            this.showEdit = true;
        },
        mark() {
            this.$inertia.put(
                route("todoItems.mark", {
                    account: this.$page.account.id,
                    project: this.$page.project.id,
                    todoList: this.todoItem.todoList.id,
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

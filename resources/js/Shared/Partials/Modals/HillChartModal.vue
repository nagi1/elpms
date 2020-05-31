<template>
    <modal @close="close" :open="open">
        <div
            v-if="!enabled && !settings"
            style="max-height:35rem;"
            class="max-w-xl bg-white rounded-lg shadow-2xl px-8 py-6 "
        >
            <h2
                class="font-semibold text-gray-800 text-xl text-center leading-tight"
            >
                Set up the Hill Chart
            </h2>

            <div class="mt-3 w-full">
                <img
                    src="@/assets/images/chart-hill-preview.png"
                    alt="Chart Hill Preview"
                    class="border-gray-400 border"
                />
                <div class="mt-5">
                    <p class="text-sm tracking-wide leading-5">
                        Hill Charts give you a bird’s eye view of what’s moving
                        forward with confidence and what isn’t. When you track a
                        to-do list on the Hill, you’ll know exactly where to
                        jump in and troubleshoot.
                        <a
                            href="https://3.basecamp-help.com/article/412-hill-charts"
                            class="normal-link"
                            >Learn more…</a
                        >
                    </p>
                </div>
            </div>

            <div
                class="mt-5 border-t border-gray-400 flex justify-center space-x-2 items-center pt-3"
            >
                <button
                    @click="settings = true"
                    class="rounded-full p-3 bg-green-500 text-gray-200 text-sm font-semibold"
                >
                    Choose to-do lists to track &#8594;
                </button>
            </div>
        </div>

        <div
            v-else
            style="max-height:35rem;"
            class="max-w-xl bg-white rounded-lg shadow-2xl px-8 py-6 "
        >
            <h2 class="font-semibold text-gray-800 text-lg leading-tight">
                Which to-do lists do you want to track on the Hill Chart?
            </h2>
            <div class="mt-5">
                <div class="flex items-baseline space-x-1">
                    <button @click="selectAll" class="normal-link">
                        Select all
                    </button>
                    <span>&bull;</span>
                    <button @click="selectNone" class="normal-link">
                        Select none
                    </button>
                </div>

                <div class="mt-8 flex flex-col space-y-3">
                    <label
                        :key="todoList.id"
                        v-for="todoList in todoLists"
                        :for="todoList.id"
                        class="block pb-2 border-b flex items-center justify-start space-x-3"
                    >
                        <input
                            type="checkbox"
                            v-model="selectedTodoLists"
                            :value="todoList.id"
                            class="form-checkbox h-5 w-5 text-green-500 border border-gray-500"
                            :id="todoList.id"
                        />

                        <span class="font-semibold text-sm">{{
                            todoList.name
                        }}</span>
                    </label>
                </div>
            </div>

            <div class="mt-5 pt-3 border-t border-gray-400 space-x-3">
                <button
                    @click="submit"
                    class="rounded-full p-3 bg-green-500 text-gray-200 text-sm font-semibold"
                >
                    Save changes
                </button>

                <button
                    @click="close"
                    class="rounded-full p-3 border-green-500 border bg-white text-green-500 text-sm font-semibold"
                >
                    Never mind
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    props: ["open", "enabled", "todoLists"],
    components: {
        Modal: () => import("@/Shared/Partials/Modals/Modal")
    },
    created() {
        this.selectedTodoLists = this.enabledTodoLists;
    },
    data() {
        return {
            settings: this.enabled ? true : false,
            selectedTodoLists: []
        };
    },
    computed: {
        enabledTodoLists() {
            return this.todoLists
                .filter(todoList => todoList.hillChartPoint.enabled)
                .map(todoList => todoList.id);
        },
        todoListsIds() {
            return this.todoLists.map(todoList => todoList.id);
        }
    },
    methods: {
        close() {
            this.settings = false;
            this.$emit("close");
        },
        selectNone() {
            this.selectedTodoLists = [];
        },
        selectAll() {
            this.selectedTodoLists = this.todoListsIds;
        },
        submit() {
            this.$inertia.put(
                route("hillCharts.enable", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    selectedTodoLists: this.selectedTodoLists
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

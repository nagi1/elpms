<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            }
        ]"
    >
        <corner-options-menu>
            <corner-option-item
                @click.native="hillChart = true"
                :item="{
                    type: 'a',
                    iconPath:
                        'M9.96,11.31C10.82,8.1 11.5,6 13,6C14.5,6 15.18,8.1 16.04,11.31C17,14.92 18.1,19 22,19V17C19.8,17 19,14.54 17.97,10.8C17.08,7.46 16.15,4 13,4C9.85,4 8.92,7.46 8.03,10.8C7.03,14.54 6.2,17 4,17V2H2V22H22V20H4V19C7.9,19 9,14.92 9.96,11.31Z',
                    text: project.hillChart
                        ? 'Hill Chart settings'
                        : 'Set up Hill Chart'
                }"
            />
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-between md:border-b-2 border-black pb-4"
            >
                <!-- title -->

                <div class="flex items-center space-x-2 md:hidden">
                    <h1 class="text-3xl  font-bold">
                        To-dos
                    </h1>
                    <pie-chart
                        :percent="piePercentage"
                        :stroke-width="10"
                        label=" "
                        label-small=" "
                        color="#2da562"
                        outerColor="#96d2b1"
                        class="h-6 w-6"
                        :opacity="0.7"
                    />
                    <span class="text-sm">{{
                        `${project.completedTodoItemsCount}/${project.todoItemsCount}`
                    }}</span>
                </div>
                <div
                    class="w-full justify-center flex space-x-2 md:space-x-0 md:justify-between items-center mt-3"
                >
                    <!-- button -->
                    <button
                        class="flex items-center rounded-full py-2 px-3 bg-green-500 text-white text-sm space-x-1"
                        @click.prevent="showCreateList = true"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-5"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z"
                            />
                        </svg>
                        <span class="tracking-tight">New list</span>
                    </button>
                    <!-- title -->
                    <div class="flex items-center space-x-2 hidden md:flex">
                        <h1 class="text-3xl  font-bold">
                            To-dos
                        </h1>
                        <pie-chart
                            :percent="piePercentage"
                            :stroke-width="10"
                            label=" "
                            label-small=" "
                            color="#2da562"
                            outerColor="#96d2b1"
                            class="h-6 w-6"
                            :opacity="0.7"
                        />
                        <span class="text-sm">{{
                            `${project.completedTodoItemsCount}/${project.todoItemsCount}`
                        }}</span>
                    </div>

                    <!-- button -->
                    <a
                        class="flex items-center rounded-full py-2 px-3 bg-gray-700 text-white text-sm  space-x-1"
                        :href="
                            route('messageBoards.create', {
                                account: $page.account.id,
                                project: $page.project.id
                            })
                        "
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-5"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z"
                            />
                        </svg>
                        <span class="tracking-tight">New message</span>
                    </a>
                </div>
            </div>

            <div v-if="project.hillChart" class="mt-10">
                <hill-chart-section :todoLists="todoLists" />
            </div>
            <div class="mt-10 md:px-10 flex flex-col space-y-5">
                <collapse-transition :duration="200">
                    <todo-list-form
                        @closed="showCreateList = false"
                        v-if="showCreateList"
                        mode="new"
                        :trix="trix"
                    />
                </collapse-transition>
                <draggable
                    tag="div"
                    :list="dragList"
                    class="space-y-4"
                    handle=".handle"
                    v-bind="dragOptions"
                    @update="onUpdate"
                >
                    <todo-list-item
                        :key="todoList.id"
                        v-for="todoList in dragList"
                        :todoList="todoList"
                    />
                </draggable>
            </div>

            <div
                v-if="archivedCount > 0"
                class="w-full mt-5 flex justify-center pt-3 border-t border-gray-400 items-center text-center"
            >
                <inertia-link
                    class="leading-5 tracking-wide text-sm flex space-x-1 items-center"
                    :href="
                        route('todoLists.archive', {
                            account: account.id,
                            project: project.id
                        })
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z"
                        />
                    </svg>

                    <span class="font-semibold"
                        >{{ archivedCount }} archived To-dos</span
                    >
                </inertia-link>
            </div>
        </div>

        <hill-chart-modal
            :enabled="project.hillChart"
            :todoLists="todoLists"
            @close="hillChart = false"
            :open="hillChart"
        />
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import CornerOptionsMenu from "@/Shared/Partials/CornerMenu/CornerOptionsMenu";
import PieChart from "@/Shared/Components/PieChart";
import { CollapseTransition } from "vue2-transitions";

export default {
    components: {
        DoubleWhiteLayout,
        ResizeObserver,
        CornerOptionsMenu,
        PieChart,
        CollapseTransition,
        HillChartSection: () =>
            import("@/Shared/Partials/HillCharts/HillChartSection"),
        HillChartModal: () => import("@/Shared/Partials/Modals/HillChartModal"),
        TodoListForm: () => import("@/Shared/Partials/TodoLists/TodoListForm"),
        TodoListItem: () => import("@/Shared/Partials/TodoLists/TodoListItem"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        draggable: () => import("vuedraggable")
    },

    props: [
        "account",
        "project",
        "todoLists",
        "trix",
        "todoItemTrix",
        "archivedCount"
    ],

    data() {
        return {
            hillChart: false,

            dragList: this.todoLists,
            showCreateList: false
        };
    },

    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "TodoList",
                ghostClass: "ghost"
            };
        },
        piePercentage() {
            if (this.project.todoItemsCount === 0) {
                return 0;
            }

            return (
                (this.project.completedTodoItemsCount /
                    this.project.todoItemsCount) *
                100
            );
        }
    },

    methods: {
        onUpdate(event) {
            setTimeout(() => {
                this.$inertia.put(
                    route("todoLists.sort", {
                        account: this.account.id,
                        project: this.project.id
                    }),
                    {
                        newSort: this.dragList.map(item => item.id)
                    }
                );
            }, 1000);
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

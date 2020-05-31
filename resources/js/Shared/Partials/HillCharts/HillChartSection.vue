<template>
    <div class=" max-w-full relative">
        <resize-observer @notify="handleResize" />
        <div v-if="!updateHillChart">
            <div class="flex items-center justify-center sm:justify-between ">
                <button
                    @click="updateHillChart = true"
                    class="hidden sm:block flex w-24 text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">Update</span>
                </button>

                <inertia-link
                    class="text-sm"
                    :href="
                        route('hillCharts.index', {
                            account: $page.account.id,
                            project: $page.project.id
                        })
                    "
                    >Last updated
                    <span class="underline">3 hours ago</span></inertia-link
                >
            </div>
            <hill-chart
                :width="width"
                :height="height"
                :preview="true"
                :key="index"
                v-model="hillChartData"
            />

            <button
                @click="updateHillChart = true"
                class="sm:hidden mt-3 flex w-full  text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
            >
                <span class="text-sm">Update</span>
            </button>
        </div>

        <div v-else>
            <div class="flex items-center justify-center sm:justify-between">
                <button
                    @click="updateHillChart = false"
                    class="hidden sm:block flex w-24 text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">Cancel</span>
                </button>

                <span
                    class="rounded-full text-center bg-yellow-300 tracking-tight py-1 px-2 text-sm font-semibold"
                    >↔ Drag each dot to adjust its position on the chart</span
                >
                <button
                    @click="submit"
                    class="hidden sm:block rounded-full p-3 border-green-500 border bg-white text-green-500 text-sm font-semibold"
                >
                    Save this update
                </button>
            </div>
            <hill-chart
                :width="width"
                :height="height"
                :preview="false"
                :key="index"
                v-model="updatedHillChartData"
            />

            <textarea
                v-model="notes"
                class="placeholder-gray-700 w-full border border-gray-400 p-2"
                placeholder="Add extra details about your changes..."
                rows="3"
            ></textarea>
            <button
                @click="submit"
                class="sm:hidden rounded-full w-full p-3 border-green-500 border bg-white text-green-500 text-sm font-semibold"
            >
                Save this update
            </button>
            <button
                @click="updateHillChart = !updateHillChart"
                class="sm:hidden mt-3 flex w-full  text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
            >
                <span class="text-sm">{{
                    updateHillChart ? "Cancel" : "Update"
                }}</span>
            </button>
        </div>
    </div>
</template>

<script>
import "vue-resize/dist/vue-resize.css";
import { ResizeObserver } from "vue-resize";
export default {
    components: {
        ResizeObserver,
        hillChart: () => import("@/Shared/Components/HillChart")
    },
    props: ["todoLists"],

    watch: {
        width(value) {
            this.index++;
        },
        updateHillChart(value) {
            this.index++;
        }
    },
    created() {
        this.updatedHillChartData = this.hillChartData;
    },
    data() {
        return {
            hillChartData: this.todoLists
                .filter(todoList => todoList.hillChartPoint.enabled)
                .map(todoList => todoList.hillChartPoint),

            updatedHillChartData: [],
            width: 600,
            height: 250,
            notes: null,
            index: 0,
            updateHillChart: false
        };
    },

    methods: {
        submit() {
            this.$inertia.post(
                route("hillCharts.update", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    data: this.updatedHillChartData,
                    notes: this.notes
                },
                {
                    preserveState: false,
                    replace: true
                }
            );
        },
        handleResize({ width, height }) {
            this.width = width;
            // this.height = height;
            this.index++;
        }
    }
};
</script>

<style></style>

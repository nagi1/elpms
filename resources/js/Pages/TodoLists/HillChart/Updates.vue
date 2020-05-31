<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            },
            {
                link: route('todoLists.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'To-dos'
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <!-- title -->
                <h1 class="text-3xl font-bold">Hill Chart Progress</h1>
            </div>

            <div class="mt-5 md:px-10 flex flex-col space-y-4">
                <div v-for="entry in updatesGroupedByDays" :key="entry.day">
                    <h2 class="divided">
                        <span class="divider"></span>
                        <span class="text-xl font-bold px-1">{{
                            entry.day
                        }}</span>
                        <span class="divider"></span>
                    </h2>
                    <hill-Chart-update
                        class="mt-5"
                        v-for="update in entry.updates"
                        :key="update.id"
                        :update="update"
                    />
                </div>
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import { groupBy, chain, sortBy } from "lodash";
export default {
    components: {
        DoubleWhiteLayout,
        HillChartUpdate: () =>
            import("@/Shared/Partials/HillCharts/HillChartUpdate.vue")
    },

    props: ["account", "project", "updates"],
    computed: {
        updatesGroupedByDays() {
            return chain(this.updates)
                .groupBy("day")
                .map((value, key) => {
                    return {
                        day: key,
                        updates: value
                    };
                })
                .value();
        }
    }
};
</script>

<style></style>

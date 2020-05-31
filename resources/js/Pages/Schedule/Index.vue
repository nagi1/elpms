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
        <div class="w-full h-full md:py-5 sm:px-12 overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center justify-between  md:border-b-2 border-black pb-4"
            >
                <!-- title -->
                <h1 class="text-3xl font-bold md:hidden">Schedule</h1>
                <div
                    class="w-full justify-center md:justify-between flex space-x-2 md:space-x-0 items-center mt-3"
                >
                    <!-- button -->
                    <button
                        @click="showEventForm = true"
                        class="flex items-center rounded-full py-2 px-3 bg-blue-600 text-white text-sm  space-x-1"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-4"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z"
                            />
                        </svg>
                        <span class="tracking-tight">New event</span>
                    </button>
                    <!-- title -->
                    <h1 class="text-3xl hidden md:block font-bold">
                        Schedule
                    </h1>

                    <!-- button -->
                    <div
                        class="flex items-center rounded-full py-2 px-3 bg-blue-500 text-white text-sm hidden md:flex space-x-1 invisible"
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
                    </div>
                </div>
            </div>

            <div class="mt-10 md:px-10 flex flex-col flex-grow space-y-10">
                <div style="height:30rem;" class="flex-grow">
                    <calendar-view
                        @click-event="handleEventClick"
                        @click-date="handleDateClick"
                        :date-classes="selectedDate"
                        :showEventTimes="true"
                        :timeFormatOptions="{
                            hour: 'numeric',
                            minute: '2-digit'
                        }"
                        :events="initEvents"
                        :doEmitItemMouseEvents="false"
                        :show-date="showDate"
                        class="theme-default  rounded-lg shadow-lg border border-gray-400"
                    >
                        <calendar-view-header
                            slot="header"
                            slot-scope="t"
                            :header-props="t.headerProps"
                            @input="setShowDate"
                        />
                    </calendar-view>
                </div>

                <div>
                    <days-events
                        :key="Object.keys(selectedDate)[0]"
                        :days="showEvents"
                    />
                </div>
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar";
import "./schedule-styles.css";
import timeSolver from "timesolver/timeSolver.min.js";
import { groupBy, chain } from "lodash";

export default {
    components: {
        DoubleWhiteLayout,

        CalendarView,
        CalendarViewHeader,

        DaysEvents: () => import("@/Shared/Partials/Schedule/DaysEvents")
    },

    props: ["account", "project", "trix", "events"],

    created() {
        this.showEvents = this.eventsGroupedByDate(new Date());
    },

    data() {
        return {
            showDate: new Date(),
            showEvents: [],
            selectedDate: {},
            initEvents: this.events.map(event => ({
                id: event.id,
                startDate: event.startsAtDatetime,
                endDate: event.endsAtDatetime,
                title: event.name,
                url: event.path,
                classes: "cursor-pointer",
                data: event,
                style: `background-color:${event.color};`
            }))
        };
    },
    methods: {
        setShowDate(d) {
            this.showDate = d;
        },
        handleDateClick(date, event) {
            this.selectedDate = {
                [timeSolver.getString(date, "yyyy-mm-dd")]: ["selectedDate"]
            };
            this.showEvents = this.eventsGroupedByDate(date);
        },
        eventsGroupedByDate(date) {
            const parentEventsIds = this.eventsForDate(date)
                .filter(event => event.data.parentEventId == null)
                .map(event => event.id);

            const events = this.eventsForDate(date)
                .concat(
                    this.initEvents.filter(event =>
                        parentEventsIds.includes(event.data.parentEventId)
                    )
                )
                .slice(0, 7);

            let currentDay = [];
            if (
                !events
                    .map(event => new Date(event.startDate).toDateString())
                    .includes(new Date(date).toDateString())
            ) {
                currentDay = [
                    {
                        date: this.formatDate(new Date(date)),
                        events: []
                    }
                ];
            }

            return currentDay.concat(
                chain(events)
                    .groupBy(event =>
                        this.formatDate(new Date(event.startDate))
                    )
                    .map((value, key) => ({
                        date: key,
                        events: value
                    }))
                    .value()
            );
        },
        eventsForDate(date) {
            return this.initEvents.filter(
                event =>
                    date >=
                        timeSolver.subtract(
                            new Date(event.startDate),
                            1,
                            "d"
                        ) && date <= new Date(event.endDate)
            );
        },
        handleEventClick(eventObj, event) {
            console.log(eventObj);
        },
        formatDate(date) {
            const isCurrentYear =
                new Date().getFullYear() === date.getFullYear();
            const options = {
                weekday: "short",
                month: "long",
                day: "numeric"
            };
            if (!isCurrentYear) {
                options.year = "numeric";
            }
            return date.toLocaleDateString("en-US", options);
        }
    }
};
</script>

<style></style>

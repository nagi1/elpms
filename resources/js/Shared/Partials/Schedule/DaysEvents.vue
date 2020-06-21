<template>
    <div class=" flex flex-grow flex-col divide-y space-y-5  divide-gray-400">
        <div
            v-for="day in days"
            :key="day.date"
            class="flex flex-col space-y-5  sm:space-x-10 sm:flex-row sm:space-y-0 items-start"
        >
            <div class="flex-grow-0 mt-5 flex-shrink-0 w-35 font-semibold">
                {{ day.date }}
            </div>
            <div class="flex-grow space-y-3 divide-y divide-gray-400 w-full">
                <div v-if="!day.events.length" class="flex flex-col space-y-5">
                    <p>
                        Nothing’s on the schedule for this day
                    </p>
                    <collapse-transition :duration="200">
                        <event-form
                            :project="$page.project"
                            :trix="$page.trix"
                            :initialDate="day.date"
                            v-if="showEventForm"
                            @closed="showEventForm = false"
                        />

                        <button
                            @click="showEventForm = true"
                            v-if="!showEventForm"
                            class="flex w-32 text-center justify-center items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white  py-2 px-3"
                        >
                            <span class="text-sm">Add an event</span>
                        </button>
                    </collapse-transition>
                </div>

                <event-item
                    :event="event"
                    v-for="event in day.events"
                    :key="event.id"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { CollapseTransition } from "vue2-transitions";

export default {
    props: ["days"],
    components: {
        CollapseTransition,
        EventForm: () => import("@/Shared/Partials/Schedule/EventForm"),
        EventItem: () => import("@/Shared/Partials/Schedule/EventItem")
    },
    data() {
        return {
            showEventForm: false
        };
    }
};
</script>

<style></style>

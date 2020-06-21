<template>
    <div class="flex flex-col space-y-5">
        <div class="flex flex-col pt-2 space-y-2">
            <div class="flex items-start space-x-2">
                <inertia-link
                    :href="event.data.path"
                    class="font-medium text-lg"
                    >{{ event.title }}</inertia-link
                >
                <div class="flex items-center space-x-1">
                    <avatar-modal
                        v-for="user in event.data.assignedTo"
                        :user="user"
                        :key="user.id"
                        size="nano"
                    />
                </div>
            </div>
            <span class="text-gray-600 text-sm"
                >{{ event.data.startsAt }} - {{ event.data.endsAt }}</span
            >
        </div>
        <collapse-transition :duration="200">
            <event-form
                :project="$page.project"
                :trix="$page.trix"
                :initialDate="event.startDate ? event.startDate : new Date()"
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
</template>

<script>
import { CollapseTransition } from "vue2-transitions";

export default {
    props: ["event"],
    components: {
        CollapseTransition,
        EventForm: () => import("@/Shared/Partials/Schedule/EventForm")
    },
    data() {
        return {
            showEventForm: false
        };
    }
};
</script>

<style></style>

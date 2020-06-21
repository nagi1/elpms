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
                link: route('schedule.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'Schedule'
            },
            {
                condition: event.archived,
                link: route('events.archive', {
                    account: account.id,
                    project: project.id,
                    event: event.id
                }),
                text: 'Archived Events'
            }
        ]"
    >
        <corner-options-menu>
            <corner-option-item
                @click.native="edit = true"
                :item="{
                    type: 'a',
                    text: 'Edit',
                    iconPath:
                        'M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z'
                }"
            />
            <corner-option-archive :model="event" />
            <!-- <corner-option-trash :model="todoItem" /> -->
        </corner-options-menu>

        <div class="w-full h-full md:py-5 sm:px-20 overflow-hidden">
            <archived-status-card
                v-if="event.archived"
                :model="event"
                class="mb-10"
            />

            <div v-if="!edit" class="content">
                <div class="flex justify-start px-5 sm:px-10">
                    <div
                        class="flex items-center flex-grow space-x-3 border-b border-gray-400 pb-4"
                    >
                        <div class="flex items-center space-x-1">
                            <single-day-month
                                :class="{
                                    'bg-blue-600': !recurring,
                                    'bg-yellow-600': recurring
                                }"
                                :day="event.singleView.start.day"
                                :month="event.singleView.start.month"
                            />
                            <span>&minus;</span>
                            <single-day-month
                                :class="{
                                    'bg-blue-600': !recurring,
                                    'bg-yellow-600': recurring
                                }"
                                :day="event.singleView.end.day"
                                :month="event.singleView.end.month"
                            />
                        </div>

                        <div class="leading-7">
                            <h1 class="text-2xl font-bold">
                                {{ event.name }}
                            </h1>
                            <span class="text-sm"
                                >Posted by {{ event.user.name }}
                                {{ event.createdAt }}</span
                            >
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-grow space-x-3 py-3  justify-start items-center"
                >
                    <span class="w-40 text-left  sm:text-right font-semibold">
                        When</span
                    >
                    <div class="flex-grow flex space-x-1 items-center">
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
                        <span>{{ event.startsAt }} &minus; </span>
                        <span>
                            {{ event.endsAt }} ({{ event.readableDiff }})</span
                        >
                    </div>
                </div>

                <div
                    class="flex flex-grow space-x-3 py-3  justify-start items-center"
                >
                    <span class="w-40 text-left  sm:text-right font-semibold">
                        Repeats</span
                    >
                    <div class="flex-grow flex space-x-1 items-center">
                        {{
                            event.occurrenceText == ""
                                ? "No Occurrences"
                                : event.occurrenceText
                        }}
                    </div>
                </div>

                <div
                    class="flex flex-grow space-x-3 py-3 justify-start items-center"
                >
                    <span class="w-40 text-left  sm:text-right font-semibold"
                        >With</span
                    >
                    <div class="flex-grow flex space-x-1 items-center">
                        <avatar-label
                            v-for="user in event.assignedTo"
                            :key="user.id"
                            :user="user"
                        />
                        <span
                            class="text-gray-500 cursor-pointer"
                            @click="edit = true"
                            v-if="!event.assignedTo.length"
                            >Type names to assign...</span
                        >
                    </div>
                </div>

                <div
                    class="flex flex-grow space-x-3 py-3 justify-start items-center"
                >
                    <span class="w-40 text-left  sm:text-right font-semibold"
                        >Notes</span
                    >
                    <div class="flex-grow flex space-x-1 items-center">
                        <div v-html="event.trixRichText"></div>
                        <span
                            class="text-gray-500 cursor-pointer"
                            @click="edit = true"
                            v-if="!event.trixRichText"
                            >Add extra details or attach file...</span
                        >
                    </div>
                </div>
            </div>

            <collapse-transition :duration="200">
                <event-form
                    :project="project"
                    :trix="eventTrix"
                    mode="edit"
                    v-if="edit"
                    :event="event"
                    @closed="edit = false"
                />
            </collapse-transition>

            <div class="mt-10">
                <boosts
                    :boosts="event.boosts"
                    :model="event.modelName"
                    :modelId="event.id"
                />
            </div>

            <change-event-section
                :model="event.modelName"
                :events="event.changeEvents"
            />

            <comment-section
                :model="event.modelName"
                :modelId="event.id"
                :comments="event.comments"
                :commentsCount="event.commentsCount"
                :trix="commentsTrix"
            />

            <div class="mt-10 sm:px-10 px-5 pt-5 border-t">
                <subscribe-section
                    :subscribers="event.subscribers"
                    :model="event.modelName"
                    :modelId="event.id"
                />
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";
import CommentSection from "@/Shared/Partials/Comments/CommentSection";
import Boosts from "@/Shared/Partials/Boosts/Boosts";
import { CollapseTransition } from "vue2-transitions";

export default {
    components: {
        DoubleWhiteLayout,
        CollapseTransition,
        CommentSection,
        Boosts,
        ArchivedStatusCard: () =>
            import("@/Shared/Components/ArchivedStatusCard"),
        SingleDayMonth: () => import("@/Shared/Components/SingleDayMonth"),
        AvatarLabel: () => import("@/Shared/Partials/User/AvatarLabel"),

        SubscribeSection: () =>
            import("@/Shared/Partials/Subscriptions/SubscribeSection"),
        CornerOptionsMenu: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionsMenu"),
        CornerOptionArchive: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionArchive"),
        CornerOptionTrash: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionTrash"),
        CornerOptionItem: () =>
            import("@/Shared/Partials/CornerMenu/CornerOptionItem"),
        ChangeEventSection: () =>
            import("@/Shared/Partials/ChangeEvents/ChangeEventSection"),
        EventForm: () => import("@/Shared/Partials/Schedule/EventForm")
    },

    props: ["account", "project", "event", "commentsTrix", "eventTrix"],
    data() {
        return {
            archived: Boolean(this.event.archived),
            edit: false,
            recurring: Boolean(this.event.parentEventId)
        };
    },

    methods: {}
};
</script>

<style></style>

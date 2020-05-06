<template>
    <div
        class="relative flex flex-col bg-white shadow rounded h-35 overflow-hidden"
    >
        <inertia-link
            class="p-3"
            :href="
                route('projects.show', {
                    account: this.$page.account.id,
                    project: project.id
                })
            "
        >
            <button
                @click.prevent="toggleOptions"
                v-if="!noOptions"
                class="absolute top-0 right-0 m-2 mt-1 text-xl text-gray-700 font-semibold z-10"
                v-html="buttonIcon"
            ></button>

            <h3 class="font-bold">{{ project.name }}</h3>
            <p
                style="min-height: 3rem;"
                class="mt-1 text-sm leading-tight tracking-tight"
            >
                {{ project.description }}
            </p>
            <div style="justify-self: end;" class="mt-3 flex space-x-1">
                <img
                    v-for="user in project.users"
                    :key="user.id"
                    class="rounded-full h-6"
                    :src="user.avatar64"
                    :alt="user.name"
                />
            </div>
        </inertia-link>
        <slide-x-right-transition origin="top right">
            <project-card-options
                @closed="toggleOptions"
                :project="project"
                v-if="options"
            />
        </slide-x-right-transition>
    </div>
</template>

<script>
import { SlideXRightTransition } from "vue2-transitions";
export default {
    props: ["project", "noOptions"],
    components: {
        ProjectCardOptions: () =>
            import("@/shared/Components/ProjectCardOptions"),
        SlideXRightTransition
    },
    data() {
        return {
            options: false
        };
    },

    computed: {
        buttonIcon() {
            return this.project.pinned
                ? '<svg xmlns="http://www.w3.org/2000/svg version="1.1" viewBox="0 0 24 24" class="h-6 fill-current text-orange-500"><path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z"/></svg>'
                : "...";
        }
    },

    methods: {
        toggleOptions() {
            this.options = !this.options;
        }
    }
};
</script>

<style></style>

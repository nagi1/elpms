<template>
    <div>
        <!-- admin panel -->
        <div
            class="hidden sm:block sm:absolute mr-3 mt-3 top-0 right-0 opacity-50 hover:opacity-100"
        >
            <div class="flex items-baseline">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4"
                    viewBox="0 0 512 512"
                >
                    <path
                        d="M448 0H320c-35.35 0-64 28.65-64 64v153.6L4.69 468.91c-6.25 6.25-6.25 16.38 0 22.63l15.77 15.77c6.25 6.25 16.38 6.25 22.63 0l36.25-36.25 36.11 36.11c6.25 6.25 16.38 6.25 22.63 0l43.16-43.16c6.25-6.25 6.25-16.38 0-22.63l-36.11-36.11L176 374.4l36.91 36.91c6.25 6.25 16.38 6.25 22.63 0l15.77-15.77c6.25-6.25 6.25-16.38 0-22.63L214.4 336l80-80H448c35.35 0 64-28.65 64-64V64c0-35.35-28.65-64-64-64zm-73.37 182.63c-12.5 12.5-32.76 12.5-45.26 0s-12.5-32.76 0-45.25c12.5-12.5 32.76-12.5 45.26 0 12.49 12.49 12.49 32.75 0 45.25zm64-64c-12.5 12.5-32.76 12.5-45.26 0s-12.5-32.76 0-45.25c12.5-12.5 32.76-12.5 45.26 0 12.49 12.49 12.49 32.75 0 45.25z"
                    />
                </svg>
                <a href="#" class="tracking-tighter text-sm">AdminPanel</a>
            </div>
        </div>
        <!-- /admin panel -->

        <!-- content -->
        <div class="content w-full px-5 sm:max-w-4xl mt-5 h-full">
            <!-- search bar -->
            <div class="sm:mx-32">
                <input
                    type="text"
                    autofocus
                    placeholder="Jump to a team or project..."
                    class="focus:outline-none px-2 py-3 w-full rounded border-2 focus:shadow-outline placeholder-gray-800"
                />
                <span class="hidden md:block text-center mt-3 text-sm"
                    >Press Ctrl+J to quickly jump to a project or team from
                    anywhere.
                </span>
            </div>
            <!-- /search bar -->

            <div class="w-full mt-5">
                <divider>
                    <span
                        class="text-lg tracking-wider text-yellow-800 opacity-75 px-1"
                        >{{ account.name }}</span
                    >
                </divider>

                <div v-if="hq">
                    <!-- HQ -->
                    <!-- HQ grid -->
                    <div
                        class="mt-5 flex justify-center items-center space-x-4"
                    >
                        <!-- HQ Logo -->
                        <label
                            for="logo"
                            class="border-2 border-gray-300 border-dashed border-gray-500 px-10 h-20 flex justify-center items-center text-xs text-gray-700 hidden sm:block cursor-pointer"
                        >
                            <div class="h-full flex items-center">
                                <input
                                    type="file"
                                    name="logo"
                                    id="logo"
                                    class="hidden"
                                />
                                Add your logo ...
                            </div>
                        </label>
                        <!-- /HQ Logo -->

                        <!-- card -->
                        <project-card
                            :project="hq"
                            class="w-56"
                            noOptions="true"
                        />
                        <!-- /card -->
                    </div>
                    <!-- /HQ grid -->
                </div>
                <!-- /HQ -->
            </div>

            <!-- Teams -->
            <div class="mt-8">
                <h2 class="divided">
                    <new-project-button for="team" />
                    <span class="divider"></span>
                    <span
                        class="text-lg tracking-wider text-yellow-800 opacity-75 px-1"
                        >Teams</span
                    >
                    <span class="divider"></span>
                </h2>

                <!-- Cards -->
                <div
                    class="features-cards grid grid-flow-row grid-cols-2 sm:grid-cols-3 gap-4 mt-8 sm:px-10"
                >
                    <!-- card -->
                    <project-card
                        v-for="team in teams"
                        :key="team.id"
                        :project="team"
                        class="w-56"
                    />
                    <!-- /card -->
                </div>
                <!-- /Cards -->
            </div>
            <!-- /Teams -->

            <!-- Projects -->
            <div class="mt-8">
                <h2 class="divided">
                    <new-project-button for="project" />
                    <span class="divider"></span>
                    <span
                        class="text-lg tracking-wider text-yellow-800 opacity-75 px-1"
                        >Projects</span
                    >
                    <span class="divider"></span>
                </h2>

                <!-- Cards -->
                <div
                    class="features-cards grid grid-flow-row grid-cols-2 sm:grid-cols-3 gap-4 mt-8 sm:px-10"
                >
                    <!-- card -->
                    <project-card
                        v-for="project in projects"
                        :key="project.id"
                        :project="project"
                    />
                    <!-- /card -->
                </div>
                <!-- /Cards -->
            </div>
            <!-- /Projects -->
        </div>
        <!-- /content -->

        <!-- footer -->
        <footer
            class="mt-5 w-full flex justify-center pt-2 pb-8 border-t border-gray-400 text-center"
        >
            <div class="inner">
                <!-- admin panel -->
                <div class="sm:hidden flex justify-center items-baseline">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4"
                        viewBox="0 0 512 512"
                    >
                        <path
                            d="M448 0H320c-35.35 0-64 28.65-64 64v153.6L4.69 468.91c-6.25 6.25-6.25 16.38 0 22.63l15.77 15.77c6.25 6.25 16.38 6.25 22.63 0l36.25-36.25 36.11 36.11c6.25 6.25 16.38 6.25 22.63 0l43.16-43.16c6.25-6.25 6.25-16.38 0-22.63l-36.11-36.11L176 374.4l36.91 36.91c6.25 6.25 16.38 6.25 22.63 0l15.77-15.77c6.25-6.25 6.25-16.38 0-22.63L214.4 336l80-80H448c35.35 0 64-28.65 64-64V64c0-35.35-28.65-64-64-64zm-73.37 182.63c-12.5 12.5-32.76 12.5-45.26 0s-12.5-32.76 0-45.25c12.5-12.5 32.76-12.5 45.26 0 12.49 12.49 12.49 32.75 0 45.25zm64-64c-12.5 12.5-32.76 12.5-45.26 0s-12.5-32.76 0-45.25c12.5-12.5 32.76-12.5 45.26 0 12.49 12.49 12.49 32.75 0 45.25z"
                        />
                    </svg>
                    <a href="#" class="tracking-tighter text-sm">AdminPanel</a>
                </div>
                <!-- /admin panel -->
                <div class="mt-3">
                    See all <a href="#" class="underline">archived</a> projects
                </div>
            </div>
        </footer>
        <!-- /footer -->
    </div>
</template>

<script>
import Layout from "@/Shared/Layouts/Layout";
import Divider from "@/Shared/Components/Divider";
import ProjectCard from "@/Shared/Components/ProjectCard";
import NewProjectButton from "@/Shared/Components/NewProjectButton";

export default {
    metaInfo: { title: "Home" },
    props: ["account", "projectTypes"],
    components: {
        Divider,
        ProjectCard,
        NewProjectButton
    },
    layout: Layout,

    computed: {
        hq() {
            return this.projectTypes
                .filter(project => {
                    return project.type == "hq";
                })
                .find(p => true);
        },
        teams() {
            return this.projectTypes.filter(project => {
                return project.type == "team";
            });
        },
        projects() {
            return this.projectTypes.filter(project => {
                return project.type == "project";
            });
        }
    }
};
</script>

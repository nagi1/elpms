<template>
    <main-white-layout>
        <!-- options circle-->
        <corner-options-button @opened="openOptions" />
        <!-- /options circle-->

        <corner-options-menu :open="options" @closed="closeOptions">
            <inertia-link
                href="#"
                class="flex items-center transition-all duration-200 ease-in-out space-x-1 hover:bg-silver-200 text-white p-3"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-5"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"
                    />
                </svg>
                <span>Stop following</span>
            </inertia-link>

            <inertia-link
                href="#"
                class="flex items-center transition-all duration-200 ease-in-out space-x-1 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-5"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"
                    />
                </svg>
                <span>Edit name, description and type</span>
            </inertia-link>

            <inertia-link
                href="#"
                class="flex items-center transition-all duration-200 ease-in-out space-x-1 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-5"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z"
                    />
                </svg>

                <span>Archive or delete</span>
            </inertia-link>

            <inertia-link
                href="#"
                class="flex items-center transition-all duration-200 ease-in-out space-x-1 hover:bg-silver-200 text-white px-3 py-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-white h-5"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
                    />
                </svg>

                <span>See items in the trash</span>
            </inertia-link>
        </corner-options-menu>
        <!-- header -->
        <div class="text-center w-full">
            <h1 class="font-bold text-3xl">{{ project.name }}</h1>
            <p class="mt-2 text-base tracking-wide text-center">
                {{ project.description }}
            </p>
            <div class="w-full flex justify-center items-center mt-5 space-x-3">
                <div class="flex justify-center items-center space-x-1">
                    <img
                        v-for="user in project.users"
                        :key="user.id"
                        class="rounded-full h-8"
                        :src="user.avatar64"
                        :alt="user.name"
                    />
                </div>
                <button
                    class="flex items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">Add/remove people</span>
                </button>
            </div>
        </div>
        <!-- header -->

        <!-- features cards -->
        <div
            class="features-cards grid grid-flow-row grid-cols-2 md:grid-cols-3 gap-4 mt-8 md:px-10"
        >
            <message-board-card
                :link="
                    route('messageBoards.index', {
                        account: $page.account.id,
                        project: $page.project.id
                    })
                "
                :messageBoards="messageBoards"
            />

            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    To-dos
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-green-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Make lists of work that needs to get done, assign items,
                        set due dates, and discuss.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    Docs &amp; Files
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-yellow-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M13,9V3.5L18.5,9M6,2C4.89,2 4,2.89 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6Z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Share docs, files, images, and spreadsheets. Organize in
                        folders so they’re easy to find.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    Chat
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-purple-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            viewBox="0 0 576 512"
                        >
                            <path
                                d="M416 192c0-88.4-93.1-160-208-160S0 103.6 0 192c0 34.3 14.1 65.9 38 92-13.4 30.2-35.5 54.2-35.8 54.5-2.2 2.3-2.8 5.7-1.5 8.7S4.8 352 8 352c36.6 0 66.9-12.3 88.7-25 32.2 15.7 70.3 25 111.3 25 114.9 0 208-71.6 208-160zm122 220c23.9-26 38-57.7 38-92 0-66.9-53.5-124.2-129.3-148.1.9 6.6 1.3 13.3 1.3 20.1 0 105.9-107.7 192-240 192-10.8 0-21.3-.8-31.7-1.9C207.8 439.6 281.8 480 368 480c41 0 79.1-9.2 111.3-25 21.8 12.7 52.1 25 88.7 25 3.2 0 6.1-1.9 7.3-4.8 1.3-2.9.7-6.3-1.5-8.7-.3-.3-22.4-24.2-35.8-54.5z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Chat casually with the group, ask random questions, and
                        share stuff without ceremony.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    Schedule
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-red-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            viewBox="0 0 448 512"
                        >
                            <path
                                d="M112 368h96c8.8 0 16-7.2 16-16v-96c0-8.8-7.2-16-16-16h-96c-8.8 0-16 7.2-16 16v96c0 8.8 7.2 16 16 16zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm0 394c0 3.3-2.7 6-6 6H54c-3.3 0-6-2.7-6-6V160h352v298z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Set important dates on a shared schedule. Subscribe to
                        events in Google Cal, iCal, or Outlook.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    Auto Check-ins
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-indigo-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            viewBox="0 0 384 512"
                        >
                            <path
                                d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Create recurring questions so you don't have to pester
                        your team about what’s going on.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
            <!-- card -->
            <a
                href="#"
                class="card h-45 sm:h-64 shadow border border-gray-400 p-2 flex flex-col"
            >
                <h2
                    class="font-bold text-sm text-center border-b pb-1 border-gray-400"
                >
                    Email Forwards
                </h2>

                <!-- card-inner -->
                <div
                    class="card-inner flex flex-col justify-center items-center mt-1 h-full"
                >
                    <div
                        class="rounded-full h-20 w-20 flex items-center justify-center bg-pink-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-current text-white h-10"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-3 hidden sm:block text-center text-sm leading-tight tracking-tight"
                    >
                        Share emails with your team, collect comments, and reply
                        directly to the original sender.
                    </p>
                </div>
                <!-- /card-inner -->
            </a>
            <!-- /card -->
        </div>
        <!-- /features cards -->
        <h2 class="divided mt-5">
            <span class="divider"></span>
            <span class="text-xl font-bold px-1"
                >{{ project.name }} Activity</span
            >
            <span class="divider"></span>
        </h2>

        <project-activity :activities="activities" class="mt-8" />
    </main-white-layout>
</template>

<script>
import MainWhiteLayout from "@/Shared/Layouts/MainWhiteLayout";
import Divider from "@/Shared/Components/Divider";
import MessageBoardCard from "@/Pages/MessageBoards/Components/MessageBoardCard";
import CornerOptionsMenu from "@/Shared/Partials/CornerMenu/CornerOptionsMenu";
import CornerOptionsButton from "@/Shared/Components/CornerOptionsButton";
import ProjectActivity from "@/Shared/Partials/Activities/ProjectActivity";

export default {
    metaInfo: { title: "Home" },
    props: ["account", "project", "messageBoards", "activities"],
    components: {
        Divider,
        MessageBoardCard,
        MainWhiteLayout,
        CornerOptionsMenu,
        CornerOptionsButton,
        ProjectActivity
    },
    data() {
        return {
            options: false
        };
    },
    methods: {
        openOptions() {
            this.options = true;
        },
        closeOptions() {
            this.options = false;
        }
    }
};
</script>

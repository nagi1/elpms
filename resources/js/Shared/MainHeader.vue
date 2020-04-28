<template>
    <header
        class="sticky top-0 z-50 background-primary pb-1 sm:pb-3 opacity-100 shadow w-full"
    >
        <!-- inner header -->
        <div class="flex justify-between items-center px-2">
            <!-- logo -->
            <inertia-link href="#" class="flex items-center text-primary mt-1">
                <logo class="fill-current h-6 sm:h-8" />
                <span class="pl-1 font-bold hidden md:inline-block"
                    >Basecamp</span
                >
            </inertia-link>
            <!-- /logo -->

            <!-- nav menu -->
            <nav class="flex w-full justify-center mt-2 sm:mt-3">
                <inertia-link
                    href="#"
                    class="flex flex-col md:flex-row text-primary font-semibold items-center text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M0,21V10L7.5,5L15,10V21H10V14H5V21H0M24,2V21H17V8.93L16,8.27V6H14V6.93L10,4.27V2H24M21,14H19V16H21V14M21,10H19V12H21V10M21,6H19V8H21V6Z"
                        />
                    </svg>
                    <span class="sm:pl-1 text-xs sm:text-sm">Home</span>
                </inertia-link>

                <button
                    @click="loadMegaMenuFor('Talks')"
                    class="flex flex-col md:flex-row md:items-center pl-2 md:pl-5 text-primary font-semibold text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        viewBox="0 0 576 512"
                    >
                        <path
                            d="M416 192c0-88.4-93.1-160-208-160S0 103.6 0 192c0 34.3 14.1 65.9 38 92-13.4 30.2-35.5 54.2-35.8 54.5-2.2 2.3-2.8 5.7-1.5 8.7S4.8 352 8 352c36.6 0 66.9-12.3 88.7-25 32.2 15.7 70.3 25 111.3 25 114.9 0 208-71.6 208-160zm122 220c23.9-26 38-57.7 38-92 0-66.9-53.5-124.2-129.3-148.1.9 6.6 1.3 13.3 1.3 20.1 0 105.9-107.7 192-240 192-10.8 0-21.3-.8-31.7-1.9C207.8 439.6 281.8 480 368 480c41 0 79.1-9.2 111.3-25 21.8 12.7 52.1 25 88.7 25 3.2 0 6.1-1.9 7.3-4.8 1.3-2.9.7-6.3-1.5-8.7-.3-.3-22.4-24.2-35.8-54.5z"
                        />
                    </svg>
                    <span class="sm:ml-1 text-xs sm:text-sm">Talks</span>
                </button>

                <button
                    @click="loadMegaMenuFor('Hey')"
                    class="flex flex-col md:flex-row pl-2 md:pl-5 text-primary font-semibold items-center text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 002 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"
                        />
                    </svg>
                    <span class="text-xs sm:text-sm">Hey!</span>
                </button>

                <a
                    href="#"
                    class="flex flex-col md:flex-row pl-2 md:pl-5 text-primary font-semibold items-center text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"
                        />
                    </svg>
                    <span class="sm:pl-1 text-xs sm:text-sm">Activity</span>
                </a>

                <a
                    href="#"
                    class="flex flex-col md:flex-row pl-2 md:pl-5 text-primary font-semibold items-center text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
                        />
                    </svg>
                    <span class="sm:pl-1 text-xs sm:text-sm">My Stuff</span>
                </a>

                <a
                    href="#"
                    class="flex flex-col md:flex-row pl-2 md:pl-5 text-primary font-semibold items-center text-sm md:text-base"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-4 md:h-5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                        />
                    </svg>
                    <span class="text-xs sm:text-sm">Find</span>
                </a>
            </nav>
            <!-- /nav menu -->

            <!-- avatar -->
            <a
                href="#"
                class="flex items-center text-primary text-sm md:text-base"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-current h-6 md:h-8"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M10 9c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm0 4c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zM7 9.5c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm3 7c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm-3-3c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm3-6c.28 0 .5-.22.5-.5s-.22-.5-.5-.5-.5.22-.5.5.22.5.5.5zM14 9c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm0-1.5c.28 0 .5-.22.5-.5s-.22-.5-.5-.5-.5.22-.5.5.22.5.5.5zm3 6c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm0-4c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm2-3.5c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm0-3.5c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1z"
                    />
                </svg>
            </a>
            <!-- /avatar -->
        </div>
        <!-- inner header -->
        <mega-menu @closed="closeMegaMenu" :key="loadMenu" :load="loadMenu" />
    </header>
</template>

<script>
import Logo from "@/Shared/Logo";
import MegaMenu from "@/Shared/MegaMenu";

export default {
    components: {
        Logo,
        MegaMenu
    },

    data() {
        return {
            loadMenu: null
        };
    },

    methods: {
        loadMegaMenuFor(menu) {
            this.loadMenu = menu + "MegaMenu";
        },

        closeMegaMenu() {
            this.loadMenu = null;
        }
    }
};
</script>

<style></style>

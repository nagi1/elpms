<template>
    <layout>
        <!-- breadcrumbs -->
        <div
            class="absolute top-0 max-w-3xl border flex flex-col justify-center bg-white w-full h-12 mt-1 px-3 shadow-xl"
        >
            <div class="flex items-center justify-center space-x-1">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="fill-current text-gray-400 h-6 inline-block"
                    version="1.1"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M6,2A4,4 0 0,1 10,6V8H14V6A4,4 0 0,1 18,2A4,4 0 0,1 22,6A4,4 0 0,1 18,10H16V14H18A4,4 0 0,1 22,18A4,4 0 0,1 18,22A4,4 0 0,1 14,18V16H10V18A4,4 0 0,1 6,22A4,4 0 0,1 2,18A4,4 0 0,1 6,14H8V10H6A4,4 0 0,1 2,6A4,4 0 0,1 6,2M16,18A2,2 0 0,0 18,20A2,2 0 0,0 20,18A2,2 0 0,0 18,16H16V18M14,10H10V14H14V10M6,16A2,2 0 0,0 4,18A2,2 0 0,0 6,20A2,2 0 0,0 8,18V16H6M8,6A2,2 0 0,0 6,4A2,2 0 0,0 4,6A2,2 0 0,0 6,8H8V6M18,8A2,2 0 0,0 20,6A2,2 0 0,0 18,4A2,2 0 0,0 16,6V8H18Z"
                    />
                </svg>

                <div class="flex items-center">
                    <template
                        v-for="(breadcrumb, index) in filteredBreadcrumbs"
                    >
                        <inertia-link
                            class="text-blue-700 underline"
                            :key="index"
                            :href="breadcrumb.link"
                            :class="{ 'font-semibold': index == 0 }"
                        >
                            {{ breadcrumb.text }}
                        </inertia-link>

                        <svg
                            v-if="
                                index !=
                                    Object.keys(filteredBreadcrumbs).length - 1
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 fill-gray-900"
                            :key="breadcrumb.link + index"
                            version="1.1"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"
                            />
                        </svg>
                    </template>
                </div>
            </div>
        </div>
        <!-- breadcrumbs -->

        <div
            class="relative panel border-2 border-gray-400  shadow-xl  max-w-4xl flex flex-col justify-center bg-white w-full py-10 mt-12 px-3  h-screen overflow-x-hidden"
        >
            <slot />
        </div>
    </layout>
</template>

<script>
import Layout from "@/Shared/Layouts/Layout";
export default {
    props: {
        breadcrumbs: {
            type: Array,
            required: true
        }
    },
    components: {
        Layout
    },

    computed: {
        filteredBreadcrumbs() {
            return this.breadcrumbs.filter(breadcrumb =>
                this.shouldShown(breadcrumb)
            );
        }
    },
    methods: {
        shouldShown(breadcrumb) {
            if (breadcrumb.condition === undefined || breadcrumb.condition) {
                return true;
            }

            return false;
        }
    }
};
</script>

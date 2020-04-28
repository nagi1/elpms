<template>
    <div class="w-full h-full absolute top-0 left-0 bg-white z-10">
        <slide-x-right-transition>
            <div v-if="rename">
                <div class="mt-5 px-3">
                    <small-form
                        :placeholder="`Name this ${project.type}`"
                        :value="project.name"
                        :post="{
                            route: {
                                name: 'projects.rename',
                                params: {
                                    account: this.$page.account.id,
                                    project: project.id
                                }
                            },
                            data: {
                                type: project.type
                            }
                        }"
                        @closed="close"
                    />
                </div>
            </div>
        </slide-x-right-transition>
        <div v-if="!rename">
            <button
                @click.prevent="close"
                class="absolute top-0 right-0 m-2 mt-1 text-xl text-gray-700 font-semibold z-10"
            >
                &Cross;
            </button>
            <h3 class="font-bold mt-3 ml-3">{{ project.name }}</h3>
            <div class="h-full mt-1 flex flex-col">
                <a
                    class="space-x-1 flex items-center hover:bg-gray-300 py-2 px-2"
                    href="#"
                    @click.prevent="togglePin"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-5"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z"
                        />
                    </svg>
                    <span class="text-sm"
                        >{{ pinned ? "Unpin" : "Pin" }} this
                        {{ project.type }}</span
                    >
                </a>
                <a
                    class="space-x-1 flex items-center hover:bg-gray-300 py-2 px-2"
                    href="#"
                    @click.prevent="openRename"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-5"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"
                        />
                    </svg>
                    <span class="text-sm">Rename this {{ project.type }}</span>
                </a>
                <a
                    class="space-x-1 flex items-center hover:bg-gray-300 py-2 px-2"
                    href="#"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-5"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M3 3H21V7H3V3M4 21V8H20V21H4M14 14V11H10V14H7L12 19L17 14H14Z"
                        />
                    </svg>

                    <span class="text-sm">Archive or delete it ...</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { SlideXRightTransition } from "vue2-transitions";
export default {
    components: {
        SmallForm: () => import("@/Shared/Components/SmallForm"),
        SlideXRightTransition
    },
    props: ["project"],
    data() {
        return {
            rename: false,
            pinned: this.project.pinned
        };
    },
    methods: {
        togglePin() {
            let state = !this.pinned;
            this.$inertia
                .post(
                    route("projects.pin", {
                        account: this.$page.account.id,
                        project: this.project.id
                    }),
                    {
                        pinned: state
                    }
                )
                .then(() => {
                    this.pinned = state;
                    this.close();
                });
        },

        close() {
            this.$emit("closed");
        },
        openRename() {
            this.rename = true;
        }
    }
};
</script>

<style></style>

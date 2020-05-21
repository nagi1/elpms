<template>
    <div
        class="flex flex-wrap space-x-2 space-y-1 items-baseline rounded-lg bg-red-100 p-1 max-w-xl"
    >
        <boost-item v-for="boost in boosts" :key="boost.id" :boost="boost" />
        <div
            v-if="!newBoost"
            @click="openNewBoost"
            class="w-8 h-8 p-1 rounded-full bg-white flex justify-center items-center border focus:shadow-outline shadow cursor-pointer hover:bg-gray-100 active:bg-gray-200"
        >
            <img
                src="@/assets/icons/boost.svg"
                class=" object-contain h-6 w-6"
            />
        </div>

        <zoom-center-transition>
            <div v-if="newBoost" class="flex items-center space-x-1">
                <img
                    class="h-6 w-6"
                    :src="$page.auth.user.avatar64"
                    :alt="$page.auth.user.name"
                />
                <span
                    class="flex items-center bg-white rounded-full px-2 py-1 space-x-1"
                >
                    <input
                        type="text"
                        ref="boostInput"
                        class="px-2 py-1 placeholder-gray-600 w-32"
                        placeholder="Booost!"
                        @keypress="validate"
                        v-model="content"
                    />

                    <emoji-adder @input="addEmoji($event)" />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-6 cursor-pointer text-green-600"
                        version="1.1"
                        viewBox="0 0 24 24"
                        @click="submit"
                    >
                        <path
                            d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"
                        />
                    </svg>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-current h-6 text-red-500 cursor-pointer"
                        version="1.1"
                        viewBox="0 0 24 24"
                        @click="close"
                    >
                        <path
                            d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12C4,13.85 4.63,15.55 5.68,16.91L16.91,5.68C15.55,4.63 13.85,4 12,4M12,20A8,8 0 0,0 20,12C20,10.15 19.37,8.45 18.32,7.09L7.09,18.32C8.45,19.37 10.15,20 12,20Z"
                        />
                    </svg>
                </span>
            </div>
        </zoom-center-transition>
    </div>
</template>

<script>
import BoostItem from "@/Shared/Partials/Boosts/BoostItem";
import EmojiAdder from "@/Shared/Components/EmojiAdder";
import { ZoomCenterTransition } from "vue2-transitions";

export default {
    props: ["boosts", "model", "modelId"],
    components: {
        BoostItem,
        ZoomCenterTransition,
        EmojiAdder
    },
    data() {
        return {
            newBoost: false,
            content: ""
        };
    },
    methods: {
        openNewBoost() {
            this.newBoost = true;
        },
        close() {
            this.content = "";
            this.newBoost = false;
        },

        submit() {
            this.$inertia
                .post(
                    route("boosts.store", {
                        account: this.$page.account.id,
                        project: this.$page.project.id
                    }),
                    {
                        content: this.content,
                        model: this.model,
                        modelId: this.modelId
                    }
                )
                .then(() => {
                    this.close();
                });
        },

        validate(event) {
            if (this.$refs.boostInput.value.length > 16) {
                event.preventDefault();
            }
        },
        addEmoji(emoji) {
            if (this.$refs.boostInput.value.length > 16) {
                return;
            }
            this.content += emoji;
        }
    }
};
</script>

<style></style>

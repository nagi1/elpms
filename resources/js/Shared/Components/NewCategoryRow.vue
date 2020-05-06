<template>
    <div
        class="flex justify-between items-baseline border-b border-gray-400 pb-4 space-y-3"
    >
        <div class="flex items-center space-x-1">
            <emoji-picker required v-model="icon" />
            <input
                placeholder="Name it"
                required
                class="font-bold placeholder-gray-600 w-full p-1"
                v-model="name"
                type="text"
            />
        </div>
        <span class="flex items-center space-x-1">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current h-7 cursor-pointer text-green-600"
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
                class="fill-current h-7 text-red-500 cursor-pointer"
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
</template>

<script>
export default {
    props: {
        modelType: {
            type: String,
            required: true
        },
        modelId: {
            required: true
        }
    },

    components: {
        EmojiPicker: () => import("@/Shared/Components/EmojiPicker")
    },

    data() {
        return {
            name: "",
            icon: ""
        };
    },

    methods: {
        close() {
            this.$emit("closed");
        },
        submit() {
            if (this.name == "" || this.icon == "") {
                return;
            }

            this.$inertia
                .post(route("categories.store"), {
                    icon: this.icon,
                    name: this.name,
                    modelType: this.modelType,
                    modelId: this.modelId
                })
                .then(() => {
                    this.close();
                });
        }
    }
};
</script>

<style></style>

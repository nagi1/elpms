<template>
    <div
        class="flex justify-between items-baseline border-b border-gray-400 pb-4 space-y-3"
    >
        <span v-if="!edit" class="font-bold">
            {{ category.fullName }}
        </span>

        <div class="flex items-center space-x-1" v-if="edit">
            <emoji-picker v-model="icon" />
            <input
                ref="editInput"
                class="font-bold w-full p-1"
                v-model="name"
                type="text"
            />
        </div>
        <span class="flex items-center space-x-1">
            <svg
                v-if="!edit"
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current h-6 cursor-pointer"
                version="1.1"
                viewBox="0 0 24 24"
                @click="openEdit"
            >
                <path
                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"
                />
            </svg>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                v-if="edit"
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
                v-if="!edit"
                xmlns="http://www.w3.org/2000/svg"
                class="fill-current h-6 cursor-pointer"
                version="1.1"
                viewBox="0 0 24 24"
                @click="remove"
            >
                <path
                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
                />
            </svg>

            <svg
                v-if="edit"
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
    components: {
        EmojiPicker: () => import("@/Shared/Components/EmojiPicker")
    },
    props: {
        category: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            edit: false,
            name: this.category.name,
            icon: this.category.icon
        };
    },

    methods: {
        openEdit() {
            new Promise(resolve => resolve((this.edit = true))).then(() => {
                this.$refs.editInput.select();
            });
        },
        close() {
            this.edit = false;
        },
        submit() {
            this.$inertia
                .put(
                    route("categories.update", {
                        category: this.category.id
                    }),
                    {
                        icon: this.icon,
                        name: this.name
                    }
                )
                .then(() => {
                    this.close();
                });
        },
        remove() {
            if (
                confirm(
                    "Any messages marked with this category will have the category removed. Still want to delete it?"
                )
            ) {
                this.$inertia.delete(
                    route("categories.destroy", {
                        category: this.category.id
                    }),
                    {
                        preserveState: true
                    }
                );
            }
        }
    }
};
</script>

<style></style>

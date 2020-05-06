<template>
    <div class="bg-orange-100 rounded-lg  py-5  w-full relative">
        <div v-if="!edit" class="flex flex-col ">
            <corner-options-menu top="mt-3">
                <a
                    href=""
                    @click.prevent="openEdit"
                    class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-white h-6"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25"
                        />
                    </svg>
                    <span class="font-medium">Edit</span>
                </a>
                <a
                    href=""
                    @click.prevent="remove(comment.id)"
                    class="flex items-center transition-all duration-200 ease-in-out space-x-2 hover:bg-silver-200 text-white px-3 py-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="fill-white h-6"
                        version="1.1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
                        />
                    </svg>
                    <span class="font-medium">Delete</span>
                </a>
            </corner-options-menu>

            <div class="flex items-start space-x-3">
                <span class="absolute top-0 text-xs right-0 mt-2 pr-12">{{
                    comment.date
                }}</span>

                <img
                    class="rounded-full h-12 w-12"
                    :src="comment.user.avatar"
                    :alt="comment.user.name"
                />

                <div class="space-y-3 pr-5">
                    <span class="font-semibold">Title,</span>
                    {{ comment.user.name }}
                    <div class="pl-3" v-html="comment.trixRichText"></div>
                </div>
            </div>

            <div class="mt-5 ml-5">
                <boosts
                    :boosts="comment.boosts"
                    model="Comment"
                    :modelId="comment.id"
                />
            </div>
        </div>

        <div v-if="edit">
            <comment-editor
                :trix="trix"
                :model="model"
                :modelId="modelId"
                :comment="comment"
                @editorClosed="edit = false"
                mode="edit"
            />
        </div>
    </div>
</template>

<script>
import CornerOptionsMenu from "@/Shared/CornerOptionsMenu";
import CommentEditor from "@/Shared/Comments/CommentEditor";
import Boosts from "@/Shared/Boosts/Boosts";

export default {
    props: ["comment", "trix", "model", "modelId"],
    components: {
        CornerOptionsMenu,
        CommentEditor,
        Boosts
    },
    data() {
        return {
            edit: false
        };
    },
    methods: {
        openEdit() {
            this.edit = true;
        },
        remove(id) {
            if (confirm("Are you sure you want to delete that comment?")) {
                this.$inertia.post(
                    route("comments.delete", {
                        account: this.$page.account.id,
                        project: this.$page.project.id,
                        comment: id
                    }),
                    {
                        model: this.model,
                        modelId: this.modelId
                    },
                    {
                        preserveState: false
                    }
                );
            }
        }
    }
};
</script>

<style></style>

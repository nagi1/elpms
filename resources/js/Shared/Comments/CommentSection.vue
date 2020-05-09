<template>
    <div>
        <div class="mt-20">
            <h2 class="divided space-x-3">
                <span
                    v-if="hasComments"
                    class="bg-gray-700 text-white font-bold flex items-center justify-center text-2xl p-4 h-12 w-12 rounded-full"
                    >{{ count }}</span
                >
                <span class="font-semibold text-2xl">Comments</span>
                <span class="divider border-black"></span>
            </h2>
        </div>

        <div
            v-if="hasComments"
            class="mt-10  flex flex-col space-y-3 items-center"
        >
            <comment
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :trix="trix"
                :model="model"
                :modelId="modelId"
            />
        </div>

        <div class="mt-10 mx-5 flex items-start space-x-2">
            <avatar-modal :user="$page.auth.user" />
            <comment-editor
                mode="new"
                :model="model"
                :modelId="modelId"
                :trix="trix"
            />
        </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/LoadingButton";
import CommentEditor from "@/Shared/Comments/CommentEditor";
import Comment from "@/Shared/Comments/Comment";

export default {
    components: {
        LoadingButton,
        CommentEditor,
        Comment,
        AvatarModal: () => import("@/Components/AvatarModal")
    },
    props: {
        model: {
            type: String,
            required: true
        },
        modelId: {
            type: Number,
            required: true
        },
        comments: {
            type: Array,
            required: true
        },
        commentsCount: {
            type: Number
        },
        trix: {}
    },

    computed: {
        hasComments() {
            return this.comments.length > 0;
        },
        count() {
            return this.commentsCount
                ? this.commentsCount
                : this.comments.length;
        }
    }
};
</script>

<style></style>

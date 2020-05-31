<template>
    <double-white-layout
        :breadcrumbs="[
            {
                link: route('projects.show', {
                    account: account.id,
                    project: project.id
                }),
                text: project.name
            },
            {
                link: route('todoLists.index', {
                    account: account.id,
                    project: project.id
                }),
                text: 'To-dos'
            }
        ]"
    >
        <div class="w-full h-full md:py-5 sm:px-20 overflow-hidden">
            <hill-Chart-update :show="true" :update="update" />

            <comment-section
                model="HillChartUpdate"
                :modelId="update.id"
                :comments="update.comments"
                :commentsCount="update.commentsCount"
                :trix="commentsTrix"
            />

            <div class="mt-10 sm:px-10 px-5 pt-5 border-t">
                <subscribe-section
                    :subscribers="update.subscribers"
                    model="HillChartUpdate"
                    :modelId="update.id"
                />
            </div>
        </div>
    </double-white-layout>
</template>

<script>
import DoubleWhiteLayout from "@/Shared/Layouts/DoubleWhiteLayout";

import CommentSection from "@/Shared/Partials/Comments/CommentSection";

export default {
    components: {
        DoubleWhiteLayout,
        CommentSection,
        HillChartUpdate: () =>
            import("@/Shared/Partials/HillCharts/HillChartUpdate.vue"),
        SubscribeSection: () =>
            import("@/Shared/Partials/Subscriptions/SubscribeSection")
    },

    props: ["account", "project", "update", "commentsTrix"]
};
</script>

<style></style>

<template>
    <div class="flex flex-col space-y-1">
        <h3 class="font-bold text-sm leading-5">
            {{ activityData.user.name }} added a new
            {{
                activityData.data.category
                    ? activityData.data.category.fullName
                    : "message"
            }}
            called
            <inertia-link
                class="normal-link text-sm"
                :href="activityData.data.path"
                >{{ activityData.data.title }}</inertia-link
            >
        </h3>
        <div>
            <p class="text-xs">{{ activityData.data.cardExcerpt }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateMessageBoardActivityCard",
    props: ["activityData"]
};
</script>

<style></style>

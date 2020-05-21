<template>
    <inertia-link
        :href="todoItem.path"
        class="flex flex-wrap space-y-1 items-center space-x-2 py-2 group"
    >
        <input
            type="checkbox"
            :title="completed ? `Completed ${todoItem.completed}` : ''"
            disabled
            :checked="completed"
            class="form-checkbox cursor-pointer h-6 w-6 text-green-500 border-gray-500"
        />

        <span>{{ todoItem.description }}</span>

        <inertia-link v-if="todoItem.excerpt" href="" :title="todoItem.excerpt"
            ><img
                class=" h-6 w-6"
                src="@/assets/icons/note.svg"
                :alt="todoItem.excerpt"
        /></inertia-link>

        <button v-if="todoItem.endsAt" class="flex items-center space-x-1">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="fill-green-500 h-6 w-6"
                version="1.1"
                viewBox="0 0 24 24"
            >
                <path
                    d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"
                />
            </svg>
            <span v-if="todoItem.startsAt">{{ todoItem.startsAt }} - </span>
            <span> {{ todoItem.endsAt }}</span>
        </button>

        <avatar-label
            v-for="user in todoItem.assignedTo"
            :key="user.id"
            :user="user"
        />
    </inertia-link>
</template>

<script>
export default {
    props: ["todoItem"],
    components: {
        AvatarLabel: () => import("@/Shared/Partials/User/AvatarLabel")
    },
    data() {
        return {
            completed: Boolean(this.todoItem.completed)
        };
    }
};
</script>

<style></style>

<template>
    <div
        style="max-height:35rem;"
        class="max-w-xl bg-white rounded-lg shadow-2xl px-8 py-6 "
    >
        <h2
            class="font-bold text-gray-900 text-2xl leading-tight border-gray-200"
        >
            How should messages be sorted?
        </h2>

        <div class="mt-5 w-full flex flex-col space-y-5">
            <label
                class="flex items-start space-x-5 justify-start"
                for="created_at"
            >
                <input
                    type="radio"
                    value="created_at"
                    class="h-7 w-7 form-radio text-gray-900"
                    v-model="sortBy"
                    id="created_at"
                />
                <div class="flex flex-col leading-5">
                    <span class="font-semibold text-lg"
                        >By original post date</span
                    >
                    <p class="text-xs">
                        The most recent message will appear first, followed by
                        older ones.
                    </p>
                </div>
            </label>
            <label
                class="flex items-start space-x-5 justify-start"
                for="last_comment"
            >
                <input
                    type="radio"
                    value="last_comment"
                    class="h-7 w-7 form-radio text-gray-900"
                    v-model="sortBy"
                    id="last_comment"
                />
                <div class="flex flex-col leading-5">
                    <span class="font-semibold text-lg">By latest comment</span>
                    <p class="text-xs">
                        Messages with recent comments will be shown first,
                        regardless of when the message was posted.
                    </p>
                </div>
            </label>
            <label class="flex items-start space-x-5 justify-start" for="title">
                <input
                    type="radio"
                    value="title"
                    class="h-7 w-7 form-radio text-gray-900"
                    v-model="sortBy"
                    id="title"
                />
                <div class="flex flex-col leading-5">
                    <span class="font-semibold text-lg"
                        >Alphabetically A-Z</span
                    >
                    <p class="text-xs">
                        Messages will be organized alphabetically by title.
                    </p>
                </div>
            </label>
            <label
                class="flex items-start space-x-5 justify-start"
                for="updated_at"
            >
                <input
                    type="radio"
                    value="updated_at"
                    class="h-7 w-7 form-radio text-gray-900"
                    v-model="sortBy"
                    id="updated_at"
                />
                <div class="flex flex-col leading-5">
                    <span class="font-semibold text-lg">Latest edited</span>
                    <p class="text-xs">
                        Messages will that been edited recently will be shown
                        first.
                    </p>
                </div>
            </label>

            <div class="mt-5">
                <p class="text-sm leading-5">
                    <span class="underline font-semibold text-yellow-900"
                        >Everyone on the project</span
                    >
                    will see messages in this order after you save.
                </p>
            </div>
        </div>

        <div
            class="mt-5 border-t border-gray-400 flex space-x-2 items-center pt-3"
        >
            <LoadingButton
                class="rounded-full p-3 bg-gray-700 text-gray-200 text-sm font-semibold"
                type="submit"
                @click.native="submit"
            >
                Save Changes
            </LoadingButton>

            <LoadingButton
                class="rounded-full p-3 bg-white border border-gray-700 font-semibold text-sm"
                type="button"
                @click.native="close"
            >
                Never mind
            </LoadingButton>
        </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/Components/LoadingButton";
export default {
    props: ["currentSortMethod"],
    components: { LoadingButton },
    data() {
        return {
            sortBy: this.currentSortMethod
        };
    },
    methods: {
        close() {
            this.$emit("close");
        },
        submit() {
            this.$inertia.put(
                route("projects.messagesSortBy", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    sortBy: this.sortBy
                },
                {
                    preserveState: false
                }
            );
        }
    }
};
</script>

<style></style>

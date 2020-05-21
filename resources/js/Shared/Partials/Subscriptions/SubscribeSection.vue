<template>
    <div class="flex flex-col space-y-5">
        <div class="flex flex-col space-y-3 pb-3 border-b">
            <h2 class="font-semibold">Subscribers</h2>
            <span class="text-sm"
                >{{ subscribersCount > 0 ? subscribersCount : "No" }} persons
                will be notified when someone comments on this message.
            </span>
            <div class="flex space-x-1 items-center">
                <avatar-modal
                    v-for="user in subscribers"
                    :key="user.id"
                    size="sm"
                    :user="user"
                />
                <inertia-link
                    :href="
                        route('subscription.show', {
                            account: $page.account.id,
                            project: $page.project.id,
                            model,
                            modelId
                        })
                    "
                    class="flex items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">Add/remove people</span>
                </inertia-link>
            </div>
        </div>
        <div class="flex flex-col space-y-3 ">
            <h2 class="font-semibold">
                {{ currentUserSubscriptionStatus.header }}
            </h2>
            <p class="text-sm">
                {{ currentUserSubscriptionStatus.paragraph }}
            </p>

            <div>
                <button
                    @click="subscribeAction"
                    class="flex items-center border border-gray-400 hover:bg-gray-200 shadow rounded-full bg-white py-2 px-3"
                >
                    <span class="text-sm">{{
                        currentUserSubscriptionStatus.button
                    }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        subscribers: {
            type: Array,
            required: true
        },
        model: {
            type: String,
            required: true
        },
        modelId: {
            required: true
        }
    },
    data() {
        return {
            user: this.$page.auth.user
        };
    },
    computed: {
        subscribersCount() {
            return this.subscribers.length;
        },
        currentUserSubscriptionStatus() {
            if (this.subscribers.some(user => user.id === this.user.id)) {
                return {
                    button: "Unsubscribe me",
                    header: "You\’re subscribed",
                    paragraph:
                        " You’ll get a notification when someone comments on this message. "
                };
            }
            return {
                button: "Subscribe me",
                header: "You\’re not subscribed",
                paragraph: "  You won’t be notified when comments are posted. "
            };
        }
    },

    methods: {
        subscribeAction() {
            this.$inertia.put(
                route("subscription.currentUser", {
                    account: this.$page.account.id,
                    project: this.$page.project.id
                }),
                {
                    model: this.model,
                    modelId: this.modelId
                }
            );
        }
    }
};
</script>

<style></style>

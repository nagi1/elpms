<template>
    <form class="bg-white w-full h-full" @submit.prevent="validate">
        <label
            :class="{ 'text-red-500': validation.hasError('name') }"
            class="has-float-label border rounded "
        >
            <input
                type="text"
                v-model="name"
                ref="name"
                class="px-1 py-2 w-full focus:shadow-outline placeholder-gray-800"
                placeholder=""
            />
            <span>{{ placeholder }}</span>
        </label>

        <div class="mt-3 flex space-x-1">
            <LoadingButton
                :loading="loading"
                class="rounded-full p-2 bg-gray-700 text-white text-sm"
                type="submit"
            >
                Save
            </LoadingButton>
            <button
                v-if="!loading"
                @click="close"
                class="rounded-full p-2 bg-white border border-gray-700 text-sm"
            >
                Cancel
            </button>
        </div>
    </form>
</template>

<script>
import LoadingButton from "@/Shared/LoadingButton";
import SimpleVueValidator from "simple-vue-validator";
const Validator = SimpleVueValidator.Validator;

export default {
    mixins: [SimpleVueValidator.mixin],
    components: {
        LoadingButton
    },
    props: {
        placeholder: {
            type: String,
            required: true
        },
        value: {
            type: String,
            default: ""
        },
        post: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            name: this.value,
            loading: false
        };
    },
    validators: {
        name: function(value) {
            return Validator.value(value).required();
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.$refs.name.focus();
            this.$refs.name.select();
        });
    },
    methods: {
        validate() {
            this.$validate().then(success => {
                if (success) {
                    this.submit();
                }
                this.$refs.name.focus();
                return false;
            });
        },
        submit() {
            this.loading = true;
            this.$inertia
                .post(route(this.post.route.name, this.post.route.params), {
                    name: this.name,
                    ...this.post.data
                })
                .then(() => {
                    this.close();
                });
        },

        close() {
            this.name = "";
            this.loading = false;
            this.$emit("closed");
        }
    }
};
</script>

<style></style>

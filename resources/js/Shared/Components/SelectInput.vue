<template>
    <div class="inline-block relative ">
        <select
            ref="input"
            v-model="selected"
            v-bind="$attrs"
            class="block appearance-none w-full bg-white border-2 border-gray-800 hover:border-gray-500 px-2 py-2 rounded-full shadow leading-tight focus:outline-none focus:shadow-outline"
        >
            <option v-if="label" value="" disabled selected>{{ label }}</option>
            <slot />
        </select>
        <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
        >
            <svg
                class="fill-current h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
            >
                <path
                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                />
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `select-input-${this._uid}`;
            }
        },
        value: [String, Number, Boolean],
        label: String,
        errors: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            selected: this.value
        };
    },
    watch: {
        selected(selected) {
            this.$emit("input", selected);
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        }
    }
};
</script>

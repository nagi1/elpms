<template>
    <div class="p-6 min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md">
            <logo class="block mx-auto w-full max-w-xs h-24 fill-current" />
            <form
                class="mt-2 bg-white rounded-lg shadow-xl border-2 overflow-hidden"
                @submit.prevent="submit"
            >
                <div class="px-10 py-4">
                    <h1 class="text-center text-xl">
                        Log in to ELPMS
                    </h1>

                    <a
                        class="btn-white text-lg block mt-5 rounded shadow border text-center"
                        href="#"
                    >
                        Use my
                        <img class="inline h-5" src="@/assets/Google.svg" />
                        Account
                    </a>

                    <divider class="mt-8">
                        <span
                            class="text-lg tracking-wider text-gray-700 opacity-75 px-1"
                            >Or, use my email address</span
                        >
                    </divider>

                    <text-input
                        v-model="form.email"
                        :errors="$page.errors.email"
                        class="mt-5"
                        label="Email or username"
                        type="email"
                        autocapitalize="off"
                    />
                    <text-input
                        v-model="form.password"
                        class="mt-6"
                        label="Password"
                        type="password"
                    />
                </div>
                <div class="px-10 pb-5">
                    <loading-button
                        :loading="sending"
                        class="btn-green text-lg shadow border justify-center w-full"
                        type="submit"
                        >Login</loading-button
                    >
                </div>
            </form>
            <div class="mt-5 flex justify-center">
                <a class="underline" tabindex="-1" href="#reset-password"
                    >Forget your password?</a
                >
            </div>
        </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/Components/LoadingButton";
import Divider from "@/Shared/Components/Divider";
import Logo from "@/Shared/Components/Logo";
import TextInput from "@/Shared/Components/TextInput";

export default {
    metaInfo: { title: "Login" },
    components: {
        LoadingButton,
        Logo,
        Divider,
        TextInput
    },
    props: {
        errors: Object
    },
    data() {
        return {
            sending: false,
            form: {
                email: "test@gmail.com",
                password: "password"
            }
        };
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia
                .post(this.route("login.attempt"), {
                    email: this.form.email,
                    password: this.form.password
                })
                .then(() => (this.sending = false));
        }
    }
};
</script>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import {
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <form @submit.prevent="submit" @keydown.enter.prevent="submit">
            <CardHeader>
                <CardTitle class="text-2xl">Connexion</CardTitle>
                <CardDescription>
                    Entrez votre email ci-dessous pour vous connecter à votre compte.
                </CardDescription>
            </CardHeader>

            <CardContent class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="email" value="Email" />

                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                    />

                    <InputError class="mt-0.5" :message="form.errors.email" />
                </div>

                <div v-if="canResetPassword" class="grid gap-2">
                    <div class="flex items-center">
                        <Label htmlFor="password">Mot de passe</Label>
                        <Link
                            :href="route('password.request')"
                            className="ml-auto inline-block text-sm underline"
                        >
                            Mot de passe oublié ?
                        </Link>
                    </div>

                    <Input
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    
                    <InputError
                        class="mt-0.5"
                        :message="form.errors.password"
                    />
                </div>
            </CardContent>

            <CardFooter class="flex flex-col gap-2 mt-4">
                <Button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="submit"
                    type="submit"
                >
                    Se connecter
                </Button>

                <div className="mt-2 text-center text-sm">
                    Vous n&apos;avez pas de compte ?
                    <Link :href="route('register')" className="underline"> S&apos;inscrire </Link>
                </div>
            </CardFooter>
        </form>
    </GuestLayout>
</template>

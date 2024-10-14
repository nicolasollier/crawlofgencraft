<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import {
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <CardHeader>
            <CardTitle class="text-xl mb-2">Mot de passe oublié ?</CardTitle>
            <CardDescription>
                Vous avez oublié votre mot de passe ? Pas de problème.
                Indiquez-nous simplement votre adresse e-mail et nous vous
                enverrons un lien de réinitialisation qui vous permettra d'en
                choisir un nouveau.
            </CardDescription>
        </CardHeader>

        <form @submit.prevent="submit">
            <CardContent>
                <Label for="email" value="Email">Email</Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </CardContent>

            <CardFooter class="mt-4 flex items-center justify-end">
                <Button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="submit"
                    type="submit"
                >
                    Envoyer le lien
                </Button>
            </CardFooter>
        </form>
    </GuestLayout>
</template>

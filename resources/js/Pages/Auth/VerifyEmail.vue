<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from "@/Components/ui/button";
import {
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Vérification d'email" />

        <CardHeader>
            <CardTitle class="text-xl">Vérification d'email</CardTitle>
            <CardDescription>
                Merci pour votre inscription ! Avant de commencer, nous devons vérifier votre adresse email.
            </CardDescription>
        </CardHeader>

        <CardContent>
            <div class="grid gap-4">
                <p class="text-sm text-gray-600">
                    Un lien de vérification a été envoyé à votre adresse email. Si vous ne l'avez pas reçu, nous pouvons vous en envoyer un nouveau.
                </p>

                <div v-if="verificationLinkSent" class="text-sm font-medium text-green-600">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            </div>
        </CardContent>

        <CardFooter class="flex flex-col gap-2 mt-4">
            <form @submit.prevent="submit" class="w-full">
                <Button
                    type="submit"
                    class="w-full cursor-pointer"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Renvoyer l'email de vérification
                </Button>
            </form>

            <div class="mt-2 text-center text-sm">
                <Link
                    :href="route('logout')"
                    method="post"
                    class="underline"
                >
                    Déconnexion
                </Link>
            </div>
        </CardFooter>
    </GuestLayout>
</template>

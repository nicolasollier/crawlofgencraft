<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";
import {
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

const form = useForm({
    pseudo: "",
    email: "",
    openai_api_key: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <CardHeader>
            <CardTitle class="text-xl">S'inscrire</CardTitle>
            <CardDescription>
                Entrez vos informations pour créer un compte
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit" @keydown.enter.prevent="submit" class="grid gap-4">
                <div class="grid gap-2 mb-4">
                    <Label for="first_name">Pseudo</Label>
                    <Input
                        id="pseudo"
                        v-model="form.pseudo"
                        type="text"
                        placeholder="Ex: JohnDoe123"
                        required
                        autofocus
                    />
                    <InputError :message="form.errors.pseudo" />
                </div>
                <div class="grid gap-2">
                    <Label for="email">E-mail</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="m@exemple.com"
                        required
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    />
                    <InputError :message="form.errors.email" />
                </div>
                <div class="grid gap-2">
                    <Label for="openai_api_key">Clé API OpenAI</Label>
                    <Input
                        id="openai_api_key"
                        v-model="form.openai_api_key"
                        type="password"
                        placeholder="sk-..."
                    />
                </div>
                <div class="grid gap-2">
                    <Label for="password">Mot de passe</Label>
                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        required
                    />
                    <InputError :message="form.errors.password" />
                </div>
                <div class="grid gap-2 mb-4">
                    <Label for="password_confirmation"
                        >Confirmer le mot de passe</Label
                    >
                    <Input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        required
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>
                <Button
                    @click="submit"
                    type="submit"
                    class="w-full cursor-pointer"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    aria-label="Créer un compte"
                >
                    Créer un compte
                </Button>
                <div class="mt-4 text-center text-sm">
                    Vous avez déjà un compte ?
                    <Link :href="route('login')" class="underline">
                        Se connecter
                    </Link>
                </div>
            </form>
        </CardContent>
    </GuestLayout>
</template>

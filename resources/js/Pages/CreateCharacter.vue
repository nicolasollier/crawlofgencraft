<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/Components/ui/card";
import { ref, computed } from 'vue';

const form = useForm({
    name: '',
    strength: '',
    agility: '',
    intelligence: '',
});

const characterGenerated = ref(false);

const generateCharacter = () => {
    form.strength = Math.floor(Math.random() * 100) + 5;
    form.agility = Math.floor(Math.random() * 100) + 5;
    form.intelligence = Math.floor(Math.random() * 100) + 5;
    characterGenerated.value = true;
};

const formIsValid = computed(() => {
    return form.name.trim() !== '' && characterGenerated.value;
});

const submit = () => {
    if (formIsValid.value) {
        form.post(route('characters.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                characterGenerated.value = false;
            },
        });
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="w-full h-full bg-zinc-100 rounded-md p-4">
            <div
                class="w-full rounded-md p-4 border border-border bg-card shadow-sm transition-all duration-200 ease-in-out hover:shadow-sm">
                <CardHeader>
                    <CardTitle>Nouveau personnage</CardTitle>
                    <CardDescription>Créez votre nouveau héros pour l'aventure</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit">
                        <fieldset>
                            <legend class="sr-only">Informations du personnage</legend>
                            <div class="grid gap-4">
                                <div>
                                    <Label for="name">Nom du personnage</Label>
                                    <Input class="mt-1" id="name" v-model="form.name" type="text" required />
                                </div>
                                <div>
                                    <Label for="strength">Force</Label>
                                    <Input class="mt-1" id="strength" v-model="form.strength" type="number" disabled />
                                </div>
                                <div>
                                    <Label for="agility">Agilité</Label>
                                    <Input class="mt-1" id="agility" v-model="form.agility" type="number" disabled />
                                </div>
                                <div>
                                    <Label for="intelligence">Intelligence</Label>
                                    <Input class="mt-1" id="intelligence" v-model="form.intelligence" type="number" disabled />
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </CardContent>
                <CardFooter class="flex justify-end gap-2">
                    <Button @click="generateCharacter" type="button" variant="secondary">
                        {{ characterGenerated ? 'Relancer les caractéristiques' : 'Générer les caractéristiques' }}
                    </Button>
                    <Button @click="submit" type="submit" :disabled="!formIsValid">Créer le personnage</Button>
                </CardFooter>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

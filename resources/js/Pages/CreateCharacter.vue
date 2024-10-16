<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/Components/ui/card";

const form = useForm({
    name: '',
    class: '',
    strength: 10,
    agility: 10,
    intelligence: 10,
});

const submit = () => {
    form.post(route('characters.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>

    <Head title="Créer un personnage" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Créer un nouveau personnage
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Nouveau personnage</CardTitle>
                        <CardDescription>Créez votre nouveau héros pour l'aventure</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit">
                            <div class="grid gap-4">
                                <div>
                                    <Label for="name">Nom du personnage</Label>
                                    <Input id="name" v-model="form.name" type="text" required />
                                </div>
                                <div>
                                    <Label for="class">Classe</Label>
                                    <Input id="class" v-model="form.class" type="text" required />
                                </div>
                                <div>
                                    <Label for="strength">Force</Label>
                                    <Input id="strength" v-model="form.strength" type="number" required />
                                </div>
                                <div>
                                    <Label for="agility">Agilité</Label>
                                    <Input id="agility" v-model="form.agility" type="number" required />
                                </div>
                                <div>
                                    <Label for="intelligence">Intelligence</Label>
                                    <Input id="intelligence" v-model="form.intelligence" type="number" required />
                                </div>
                            </div>
                        </form>
                    </CardContent>
                    <CardFooter>
                        <Button @click="submit" type="submit">Créer le personnage</Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Input from "@/Components/ui/input/Input.vue";
import Badge from "@/Components/ui/badge/Badge.vue";
import Label from "@/Components/ui/label/Label.vue";
import Button from "@/Components/ui/button/Button.vue";
import { PlusCircle } from "lucide-vue-next";
import { ref } from 'vue';

const props = defineProps({
    characters: {
        type: Array,
        required: true,
    },
    noCharacters: {
        type: Boolean,
        required: true,
    },
});

const cardHovered = ref('false')
const character = props.characters[0];

const submitMessage = () => {
    console.log("Sending message:", userMessage.value);
    userMessage.value = "";
};
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="noCharacters" class="flex justify-center bg-backgroundl">
            <div @mouseover="cardHovered = true" @mouseleave="cardHovered = false"
                class="w-full text-center rounded-md p-8 border border-border bg-card shadow-sm transition-all duration-200 ease-in-out hover:shadow-sm">
                <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de personnage ?</h2>
                <p class="text-muted-foreground text-md">
                    Créez votre premier héros et commencez votre aventure !
                </p>

                <img class="mx-auto mt-6 w-full max-w-sm object-cover opacity-75 transition-all duration-300 ease-in-out"
                    :class="{ 'grayscale': !cardHovered }"
                    src="https://res.cloudinary.com/dnqqx8hbb/image/upload/w_1000,ar_1:1,c_fill,g_auto,e_art:hokusai/v1729084611/empty_placeholder_xfxhgx.png"
                    alt="Créez votre personnage" />

                <Link :href="route('characters.create')">
                    <Button size="lg" class="mt-6">
                        <PlusCircle class="mr-2 h-5 w-5" />
                        Créer un personnage
                    </Button>
                </Link>
            </div>
        </div>

        <div v-else class="grid flex-1 gap-4 overflow-auto p-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="relative hidden flex-col items-start gap-8 md:flex">
                <form class="grid w-full items-start gap-6">
                    <!-- Character fieldset -->
                    <fieldset class="grid gap-6 rounded-lg border p-4">
                        <legend class="-ml-1 px-1 text-sm font-medium">
                            Fiche de personnage
                        </legend>
                        <div class="grid gap-3">
                            <Label for="character_name">Nom</Label>
                            <Input id="character_name" v-model="character_name" type="text" placeholder="John Doe" />
                        </div>
                        <div class="grid grid-col gap-4">
                            <div class="grid gap-3">
                                <Label for="health">PV</Label>
                                <Input id="health" v-model="health" type="number" placeholder="100" disabled />
                            </div>
                            <div class="grid gap-3">
                                <Label for="mana">Mana</Label>
                                <Input id="mana" v-model="mana" type="number" placeholder="100" disabled />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <!-- Right column (output and input) -->
            <div class="relative flex h-full min-h-[50vh] flex-col rounded-xl bg-muted/50 p-4 lg:col-span-2">
                <Badge variant="outline" class="absolute right-3 top-3">Output</Badge>
                <div class="flex-1">
                    <!-- Output content goes here -->
                </div>
                <form @submit.prevent="submitMessage" class="relative overflow-hidden">
                    <Label for="answer" class="sr-only">Answer</Label>
                    <!-- Buttons for choice will go here -->
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

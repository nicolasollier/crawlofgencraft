<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Input from "@/Components/ui/input/Input.vue";
import Badge from "@/Components/ui/badge/Badge.vue";
import Label from "@/Components/ui/label/Label.vue";
import Button from "@/Components/ui/button/Button.vue";
import { PlusCircle } from "lucide-vue-next";
import { Heart, Zap, Coins, Shield, Sword } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    characters: {
        type: Array,
        required: true,
    },
});

const character = props.characters[0];
const noCharacters = !character;
const inventory = character ? character.inventory.map(entry => entry.item) : [];

const submitMessage = () => {
    console.log("Sending message:", userMessage.value);
    userMessage.value = "";
};
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="noCharacters" class="flex flex-col h-full">
            <div class="flex-grow bg-zinc-100 flex justify-center items-center rounded-md">
                <div @mouseover="cardHovered = true" @mouseleave="cardHovered = false"
                    class="w-full max-w-2xl text-center rounded-md p-8 border border-border bg-white">
                    <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de personnage ?</h2>
                    <p class="text-muted-foreground text-md">
                        Créez votre premier héros et commencez votre aventure !
                    </p>

                    <img class="mx-auto mt-6 w-full max-w-sm object-cover opacity-75 transition-all duration-300 ease-in-out"
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
        </div>

        <div v-else class="grid flex-1 gap-4 h-full overflow-hidden p-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="flex flex-col h-full overflow-hidden space-y-4">
                <!-- Fiche de personnage -->
                <fieldset class="rounded-lg border p-4">
                    <legend class="px-2 text-sm font-medium">
                        Fiche de personnage
                    </legend>
                    <div class="space-y-4">
                        <div>
                            <Label for="character_name">Nom</Label>
                            <Input id="character_name" v-model="character.name" type="text" placeholder="John Doe" disabled />
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <Heart class="w-4 h-4 text-zinc-800" />
                                <div class="flex-grow">
                                    <div class="h-2 bg-zinc-100 overflow-hidden">
                                        <div class="h-full bg-zinc-800"
                                            :style="{ width: `${(character.hp / 100) * 100}%` }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <Zap class="w-4 h-4 text-zinc-800" />
                                <div class="flex-grow">
                                    <div class="h-2 bg-zinc-100 overflow-hidden">
                                        <div class="h-full bg-zinc-800"
                                            :style="{ width: `${(character.mana / 100) * 100}%` }"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Inventaire -->
                <fieldset class="rounded-lg border p-4">
                    <legend class="px-2 text-sm font-medium">
                        Inventaire
                    </legend>
                    <div>
                        <div v-if="inventory.length === 0">
                            <p class="text-zinc-500 text-sm">Vous n'avez pas d'objets dans votre inventaire.</p>
                        </div>
                        <div v-else class="max-h-[300px] overflow-y-auto pr-2 space-y-2">
                            <div v-for="item in inventory" :key="item.id"
                                class="bg-white p-3 rounded-md border border-zinc-200">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-base font-semibold">{{ item.name }}</h3>
                                </div>
                                <p class="text-xs text-zinc-600 mt-1 mb-2">{{ item.description }}</p>
                                <div class="flex gap-2 text-xs">
                                    <span v-if="item.armor_bonus" class="text-zinc-800 bg-zinc-100 px-2 py-1 rounded-full">
                                        <Shield class="inline w-3 h-3 mr-1" />
                                        +{{ item.armor_bonus }}
                                    </span>
                                    <span v-if="item.damage_bonus" class="text-zinc-800 bg-zinc-100 px-2 py-1 rounded-full">
                                        <Sword class="inline w-3 h-3 mr-1" />
                                        +{{ item.damage_bonus }}
                                    </span>
                                    <span v-if="item.value" class="text-zinc-800 bg-zinc-100 px-2 py-1 rounded-full">
                                        <Coins class="inline w-3 h-3 mr-1" />
                                        {{ item.value }} po
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <!-- Right column (output and input) -->
            <div class="relative flex flex-col h-full rounded-xl bg-muted/50 p-4 lg:col-span-2 overflow-hidden">
                <Badge variant="outline" class="absolute right-3 top-3">Output</Badge>
                <div class="flex-1 overflow-y-auto">
                    <!-- Output content goes here -->
                </div>
                <form @submit.prevent="submitMessage" class="relative mt-4">
                    <Label for="answer" class="sr-only">Answer</Label>
                    <!-- Buttons for choice will go here -->
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

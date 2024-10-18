<script setup>
import { Heart, Zap, Coins, Shield, Sword } from 'lucide-vue-next';
import Input from "@/Components/ui/input/Input.vue";
import Label from "@/Components/ui/label/Label.vue";
import { useCharacterStore } from '@/stores/characterStore';
import { storeToRefs } from 'pinia';

const characterStore = useCharacterStore();
const { currentCharacter, inventory } = storeToRefs(characterStore);
</script>

<template>
    <div class="flex flex-col h-full overflow-hidden space-y-4">
        <!-- Fiche de personnage -->
        <fieldset class="rounded-lg border p-4">
            <legend class="px-2 text-sm font-medium">
                Fiche de personnage
            </legend>
            <div class="space-y-4">
                <div>
                    <Label for="character_name">Nom</Label>
                    <Input id="character_name" v-model="currentCharacter.name" type="text" placeholder="John Doe"
                        disabled />
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <Heart class="w-4 h-4 text-zinc-800" />
                        <div class="flex-grow">
                            <div class="h-2 bg-zinc-100 overflow-hidden">
                                <div class="h-full bg-zinc-800"
                                    :style="{ width: `${(currentCharacter.hp / 100) * 100}%` }">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <Zap class="w-4 h-4 text-zinc-800" />
                        <div class="flex-grow">
                            <div class="h-2 bg-zinc-100 overflow-hidden">
                                <div class="h-full bg-zinc-800"
                                    :style="{ width: `${(currentCharacter.mana / 100) * 100}%` }"></div>
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
                <div v-else class="max-h-[420px] overflow-y-auto pr-4 space-y-2 inventory-scrollbar">
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
</template>

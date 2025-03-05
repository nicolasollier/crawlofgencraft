<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CharacterInfos from '@/Layouts/CharacterInfos.vue';
import { router, Link } from '@inertiajs/vue3';
import Output from '@/Layouts/Output.vue';
import Button from "@/Components/ui/button/Button.vue";
import { PlusCircle } from "lucide-vue-next";
import { useCharacterStore } from '@/stores/characterStore';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';

const characterStore = useCharacterStore();
const { hasCharacters, currentCharacter, inventory } = storeToRefs(characterStore);

const cardHovered = ref(false);
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="hasCharacters" class="grid flex-1 gap-4 h-full overflow-hidden p-4 md:grid-cols-2 lg:grid-cols-3">
            <CharacterInfos 
                :currentCharacter="currentCharacter" 
                :inventory="inventory"
            />
            <Output />
        </div>

        <div v-else class="flex flex-col h-full">
            <div class="flex-grow bg-zinc-100 flex justify-center items-center rounded-md">
                <div @mouseover="cardHovered = true" @mouseleave="cardHovered = false"
                    class="w-full max-w-2xl text-center rounded-md p-8 border border-border bg-white">
                    <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de personnage ?</h2>
                    <p class="text-muted-foreground text-md">
                        Créez votre premier héros et commencez votre aventure !
                    </p>

                    <img class="mx-auto mt-6 w-full max-w-sm object-cover opacity-90 transition-all duration-300 ease-in-out"
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
    </AuthenticatedLayout>
</template>

<style scoped>
.inventory-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #27272a transparent;
}

.inventory-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.inventory-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.inventory-scrollbar::-webkit-scrollbar-thumb {
    background-color: #27272a;
    border-radius: 0;
}
</style>

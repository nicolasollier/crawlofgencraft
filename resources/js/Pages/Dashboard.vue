<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CharacterInfos from '@/Layouts/CharacterInfos.vue';
import { Link } from '@inertiajs/vue3';
import Output from '@/Layouts/Output.vue';
import Button from "@/Components/ui/button/Button.vue";
import { PlusCircle } from "lucide-vue-next";
import { useCharacterStore } from '@/stores/characterStore';
import { useDungeonStore } from '@/stores/dungeonStore';
import { onMounted } from 'vue';

const props = defineProps({
    characters: {
        type: Array,
        required: true,
    },
    dungeons: {
        type: Array,
        required: true,
    },
});

const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();

onMounted(() => {
    characterStore.setCharacters(props.characters);
    dungeonStore.setDungeons(props.dungeons);
});
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="!characterStore.hasCharacters" class="flex flex-col h-full">
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
            <CharacterInfos />
            <Output />
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

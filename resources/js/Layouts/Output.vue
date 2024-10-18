<script setup>
import Badge from "@/Components/ui/badge/Badge.vue";
import Button from "@/Components/ui/button/Button.vue";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { useDungeonStore } from '@/stores/dungeonStore';
import { useCharacterStore } from '@/stores/characterStore';
import { ref, computed } from 'vue';
import { PlusCircle } from "lucide-vue-next";
import { useForm } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';

const dungeonStore = useDungeonStore();
const { currentDungeon, hasDungeons } = storeToRefs(dungeonStore);
const characterStore = useCharacterStore();
const userMessage = ref('');

const dungeonSize = ref('medium');
const dungeonSizes = [
    { value: 'small', label: 'Petit' },
    { value: 'medium', label: 'Moyen' },
    { value: 'large', label: 'Grand' },
];

const messages = ref([
    { type: 'system', content: 'Bienvenue dans le donjon !' },
    { type: 'player', content: 'Je regarde autour de moi.' },
    { type: 'system', content: 'Vous vous trouvez dans une salle sombre. Il y a une porte à votre gauche et un coffre à votre droite.' },
]);

const choices = ref(['Ouvrir la porte', 'Examiner le coffre', 'Crier "Y a quelqu\'un ?"']);

const form = useForm({
    size: dungeonSize.value,
    character_id: computed(() => characterStore.currentCharacter?.id),
});

const createDungeon = () => {
    form.post(route('dungeon.create'), {
        preserveScroll: true,
        onSuccess: (response) => {
            dungeonStore.addDungeon(response.data);
            dungeonStore.setCurrentDungeon(response.data);
        },
    });
};

const submitMessage = () => {
    // Implement message submission logic here
    console.log(userMessage.value);
};
</script>

<template>
    <div class="relative flex flex-col h-full rounded-xl bg-muted/50 p-4 lg:col-span-2 overflow-hidden">
        <Badge variant="outline" class="absolute hidden md:block right-3 top-3">Output</Badge>

        <div v-if="!hasDungeons || !currentDungeon" class="flex flex-col h-full justify-center items-center">
            <div class="text-center flex flex-col items-center">
                <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de donjon ?</h2>
                <p class="text-muted-foreground text-md mb-6">
                    Créez votre premier donjon et commencez votre aventure !
                </p>
                <div class="mb-4">
                    <Select v-model="dungeonSize">
                        <SelectTrigger class="w-48 mb-2">
                            <SelectValue placeholder="Taille du donjon" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="size in dungeonSizes" :key="size.value" :value="size.value">
                                {{ size.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>

            <img class="mx-auto mb-10 w-full max-w-sm object-cover opacity-85"
                src="https://res.cloudinary.com/dnqqx8hbb/image/upload/empty_dungeon_placeholder_lmnfoy.png"
                alt="Créez votre donjon" draggable="false" />

            <Button size="lg" @click.prevent="createDungeon">
                <PlusCircle class="mr-2 h-5 w-5" />
                Créer un donjon
            </Button>
        </div>

        <div v-else class="flex flex-col h-full">
            <div class="flex-1 overflow-y-auto mb-4 space-y-4">
                <div class="text-xl font-bold mb-4">
                    {{ (currentDungeon || dungeonStore.currentDungeon).name }}
                </div>

                <div v-for="(message, index) in messages" :key="index"
                    :class="{ 'bg-blue-100 p-2 rounded': message.type === 'player', 'bg-gray-100 p-2 rounded': message.type === 'system' }">
                    {{ message.content }}
                </div>
            </div>

            <form @submit.prevent="submitMessage" class="space-y-4">
                <div class="flex flex-wrap gap-2">
                    <Button v-for="choice in choices" :key="choice" variant="outline" @click="userMessage = choice">
                        {{ choice }}
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>

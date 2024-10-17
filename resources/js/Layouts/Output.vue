<script setup>
import Badge from "@/Components/ui/badge/Badge.vue";
import Button from "@/Components/ui/button/Button.vue";
import { useDungeonStore } from '@/stores/dungeonStore';
import { ref, computed } from 'vue';
import { PlusCircle } from "lucide-vue-next";
import { Link } from '@inertiajs/vue3';

const dungeonStore = useDungeonStore();
const userMessage = ref('');

const currentDungeon = computed(() => dungeonStore.currentDungeon);

const submitMessage = () => {
    console.log("Sending message:", userMessage.value);
    userMessage.value = "";
};

const messages = ref([
    { type: 'system', content: 'Bienvenue dans le donjon !' },
    { type: 'player', content: 'Je regarde autour de moi.' },
    { type: 'system', content: 'Vous vous trouvez dans une salle sombre. Il y a une porte à votre gauche et un coffre à votre droite.' },
]);

const choices = ref(['Ouvrir la porte', 'Examiner le coffre', 'Crier "Y a quelqu\'un ?"']);
</script>

<template>
    <div class="relative flex flex-col h-full rounded-xl bg-muted/50 p-4 lg:col-span-2 overflow-hidden">
        <Badge variant="outline" class="absolute right-3 top-3">Output</Badge>

        <div v-if="!currentDungeon" class="flex flex-col h-full justify-center items-center">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de donjon ?</h2>
                <p class="text-muted-foreground text-md mb-6">
                    Créez votre premier donjon et commencez votre aventure !
                </p>

                <img class="mx-auto mb-8 w-full max-w-sm object-cover opacity-75"
                    src="https://res.cloudinary.com/dnqqx8hbb/image/upload/empty_dungeon_placeholder_lmnfoy.png"
                    alt="Créez votre donjon"
                    draggable="false" />

                <Link>
                    <Button size="lg">
                        <PlusCircle class="mr-2 h-5 w-5" />
                        Créer un donjon
                    </Button>
                </Link>
            </div>
        </div>

        <div v-else class="flex flex-col h-full">
            <div class="flex-1 overflow-y-auto mb-4 space-y-4">
                <div class="text-xl font-bold mb-4">
                    {{ currentDungeon.name }}
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

                <div class="flex space-x-2">
                    <input
                        id="answer"
                        v-model="userMessage"
                        class="flex-1 min-w-0 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="Tapez votre message ici..."
                    />
                    <Button type="submit">Envoyer</Button>
                </div>
            </form>
        </div>
    </div>
</template>

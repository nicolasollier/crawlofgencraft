<script setup>
import Badge from "@/Components/ui/badge/Badge.vue";
import Button from "@/Components/ui/button/Button.vue";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { PlusCircle, Castle } from "lucide-vue-next";
import { useForm } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { ref, computed, watch, onMounted } from 'vue';

import { useDungeonStore } from '@/stores/dungeonStore';
import { useCharacterStore } from '@/stores/characterStore';

// Store setup
const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();
const { currentDungeon, hasDungeons } = storeToRefs(dungeonStore);

// Computed properties
const currentRoom = computed(() => {
    if (!currentDungeon.value || !currentDungeon.value.rooms || currentDungeon.value.rooms.length === 0) {
        return null;
    }
    return currentDungeon.value.rooms[currentDungeon.value.room_count];
});

// Reactive refs
const userMessage = ref('');
const dungeonSize = ref('medium');
const typedDescription = ref('');
const isTyping = ref(false);

// Constants
const dungeonSizes = [
    { value: 'small', label: 'Petit' },
    { value: 'medium', label: 'Moyen' },
    { value: 'large', label: 'Grand' },
];

// Form setup
const form = useForm({
    size: dungeonSize,
    character_id: computed(() => characterStore.currentCharacter?.id),
    dungeon_id: computed(() => currentDungeon.value?.id),
});

// Methods
const createDungeon = () => {
    form.post(route('dungeon.create'), {
        preserveScroll: true,
        onSuccess: (response) => {
            dungeonStore.addDungeon(response.data);
            dungeonStore.setCurrentDungeon(response.data);
        },
    });
};

const submitMessage = (action) => {
    form.post(route('dungeon.progress'), {
        preserveScroll: true,
        onSuccess: (response) => {
            dungeonStore.updateDungeon(response.data);
        },
    });
};

const typeDescription = (text) => {
    isTyping.value = true;
    typedDescription.value = '';
    let index = 0;
    const interval = setInterval(() => {
        if (index < text.length) {
            typedDescription.value += text[index];
            index++;
        } else {
            clearInterval(interval);
            isTyping.value = false;
        }
    }, 30);
};

// Watchers
watch(() => currentRoom.value?.description, (newDescription) => {
    if (newDescription) {
        typeDescription(newDescription);
    }
});

// Lifecycle hooks
onMounted(() => {
    if (currentRoom.value?.description) {
        typeDescription(currentRoom.value.description);
    }
});
</script>

<template>
    <div class="relative flex flex-col h-full rounded-xl bg-muted/50 py-8 px-12 lg:col-span-2 overflow-hidden">
        <!-- No dungeon state -->
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

        <!-- Current room state -->
        <div v-else-if="currentRoom" class="flex flex-col h-full">
            <div class="flex flex-wrap items-center text-sm pb-4 mb-4 gap-2">
                <span class="flex items-center text-zinc-800 font-semibold">
                    <Castle class="inline-block w-4 h-4 mr-2" />
                    Donjon {{ currentDungeon.size }}
                </span>
                <span class="inline text-zinc-400">|</span>
                <span class="text-zinc-800 font-semibold">Salle {{ currentRoom.room_number }}</span>
            </div>

            <div class="text-sm text-zinc-800">
                <p :class="{ 'typing-cursor': isTyping }">
                    {{ typedDescription }}
                </p>
            </div>

            <div class="flex-grow"></div>

            <div class="mt-4 space-y-2 sm:space-y-0 sm:space-x-2 sm:flex sm:flex-wrap">
                <Button v-for="option in currentRoom.options" :key="option" @click="submitMessage(option)"
                    class="w-full sm:w-auto">
                    {{ option }}
                </Button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.typing-cursor::after {
    content: '|';
    animation: blink 0.7s infinite;
}

@keyframes blink {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}
</style>
